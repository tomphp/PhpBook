<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use CocktailRater\Application\Exception\ApplicationException;
use CocktailRater\Application\Visitor\Query\ListRecipes;
use CocktailRater\Application\Visitor\Query\ListRecipesHandler;
use CocktailRater\Application\Visitor\Query\ListRecipesQuery;
use CocktailRater\Application\Visitor\Query\ListRecipesQueryHandler;
use CocktailRater\Application\Visitor\Query\ViewRecipeHandler;
use CocktailRater\Application\Visitor\Query\ViewRecipeQuery;
// leanpub-start-insert
use CocktailRater\Domain\Builder\RecipeBuilder;
// leanpub-end-insert
use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\Amount;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\RecipeId;
use CocktailRater\Domain\Unit;
use CocktailRater\Domain\User;
use CocktailRater\Domain\Username;
use CocktailRater\Testing\Repository\TestRecipeRepository;
use PHPUnit_Framework_Assert as Assert;

/**
 * Behat context class.
 */
class FeatureContext implements SnippetAcceptingContext
{
    /** @var RecipeRepository */
    private $recipeRepository;

    /** @var mixed */
    private $result;

    /** @var ApplicationException */
    private $error;

    /** @var array */
    private $recipes = [];

    /**
     * Initializes context.
     *
     * Every scenario gets its own context object.
     * You can also pass arbitrary arguments to the context constructor through
     * behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $this->recipeRepository = new TestRecipeRepository();
        $this->error = null;
    }

    /**
     * @Given there are no recipes
     */
    public function thereAreNoRecipes()
    {
        $this->recipeRepository->clear();
    }

    /**
     * @When I request a list of recipes
     */
    public function iRequestAListOfRecipes()
    {
        $this->storeRecipes();

        $query = new ListRecipesQuery();
        $handler = new ListRecipesHandler($this->recipeRepository);

        $this->result = $handler->handle($query);
    }

    /**
     * @Then I should see an empty list
     */
    public function iShouldSeeAnEmptyList()
    {
        $recipes = $this->result->getRecipes();

        Assert::assertInternalType('array', $recipes);
        Assert::assertEmpty($recipes);
    }

    /**
     * @Given there's a recipe for :name by user :user with :rating stars
     */
    public function theresARecipeForByUserWithStars($name, $user, $rating)
    {
        // leanpub-start-insert
        $builder = $this->getRecipeBuilder($name);

        $builder->setUser(User::fromValues($user));
        $builder->setRating(new Rating($rating));
        // leanpub-end-insert
    }

    /**
     * @Then I should see a list of recipes containing:
     */
    public function iShouldSeeAListOfRecipesContaining(TableNode $table)
    {
        $callback = function ($recipe) {
            return [
                (string) $recipe['name'],
                (float) $recipe['rating'],
                (string) $recipe['user']
            ];
        };

        Assert::assertEquals(
            array_map($callback, $this->result->getRecipes()),
            array_map($callback, $table->getHash())
        );
    }

    /**
     * @When I request to view recipe using a bad id
     */
    public function iRequestToViewRecipeUsingABadId()
    {
        try {
            $query = new ViewRecipeQuery('bad id');
            $handler = new ViewRecipeHandler($this->recipeRepository);

            $this->result = $handler->handle($query);
        } catch (ApplicationException $e) {
            $this->error = $e;
        }
    }

    /**
     * @When I request to view recipe for :name
     */
    public function iRequestToViewRecipeFor($name)
    {
        $this->storeRecipes();

        $query = new ViewRecipeQuery($this->recipes[$name]['id']);
        $handler = new ViewRecipeHandler($this->recipeRepository);

        $this->result = $handler->handle($query);
    }

    /**
     * @Then I should see an invalid id error
     */
    public function iShouldSeeAnInvalidIdError()
    {
        Assert::assertInstanceOf(
            'CocktailRater\Application\Exception\InvalidIdException',
            $this->error,
            'Expected an invalid id error.'
        );
    }

    /**
     * @Given the recipe for :name has method:
     */
    public function theRecipeForHasMethod($name, PyStringNode $method)
    {
        // leanpub-start-insert
        $this->getRecipeBuilder($name)->setMethod($method->getRaw());
        // leanpub-end-insert
    }

    /**
     * @Given the recipe for :name has measured ingredients:
     */
    public function theRecipeForHasMeasuredIngredients($name, TableNode $ingredients)
    {
        // leanpub-start-insert
        $builder = $this->getRecipeBuilder($name);

        foreach ($ingredients->getHash() as $ingredient) {
            $builder->addIngredient(
                Amount::fromValues(
                    $ingredient['amount'],
                    $ingredient['unit']
                ),
                new Ingredient($ingredient['name'])
            );
        }
        // leanpub-end-insert
    }

    /**
     * @Then I should see a field :name with value of :value
     */
    public function iShouldSeeAFieldWithValueOf($name, $value)
    {
        Assert::assertEquals($value, $this->getResultField($name));
    }

    /**
     * @Then I should see a field :name with value:
     */
    public function iShouldSeeAFileWithValue($name, PyStringNode $value)
    {
        Assert::assertEquals($value->getRaw(), $this->getResultField($name));
    }

    /**
     * @Then I should see a list of measured ingredients containing:
     */
    public function iShouldSeeAListOfMeasuredIngredientsContaining(TableNode $table)
    {
        Assert::assertEquals(
            $table->getHash(),
            $this->getResultField('measuredIngredients')
        );
    }

    // leanpub-start-insert
    /**
     * @param string $name
     *
     * @return RecipeBuilder
     */
    private function getRecipeBuilder($name)
    {
        if (!isset($this->recipes[$name])) {
            $this->recipes[$name]['builder'] = new RecipeBuilder();
            $this->recipes[$name]['builder']->setName($name);
        }

        return $this->recipes[$name]['builder'];
    }
    // leanpub-end-insert

    private function storeRecipes()
    {
        // leanpub-start-insert
        foreach ($this->recipes as $name => &$recipeSpec) {
            $recipe = $recipeSpec['builder']->build();

            $this->recipeRepository->store($recipe);

            $recipeSpec['id'] = $this->recipeRepository
                                     ->getLastInsertId()
                                     ->getValue();
        }
        // leanpub-end-insert
    }

    /** @return mixed */
    private function getResultField($name)
    {
        $getter = 'get' . ucfirst($name);

        return $this->result->$getter();
    }
}
