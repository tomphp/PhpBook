<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
// leanpub-start-insert
use CocktailRater\Application\Exception\ApplicationException;
// leanpub-end-insert
use CocktailRater\Application\Visitor\Query\ListRecipes;
use CocktailRater\Application\Visitor\Query\ListRecipesHandler;
use CocktailRater\Application\Visitor\Query\ListRecipesQuery;
use CocktailRater\Application\Visitor\Query\ListRecipesQueryHandler;
// leanpub-start-insert
use CocktailRater\Application\Visitor\Query\ViewRecipeHandler;
use CocktailRater\Application\Visitor\Query\ViewRecipeQuery;
use CocktailRater\Domain\RecipeId;
use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\Amount;
use CocktailRater\Domain\MeasuredIngredient;
// leanpub-end-insert
use CocktailRater\Domain\CocktailName;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\Recipe;
// leanpub-start-insert
use CocktailRater\Domain\Method;
// leanpub-end-insert
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

    // leanpub-start-insert
    /** @var ApplicationException */
    private $error;

    /** @var array */
    private $recipes = [];
    // leanpub-end-insert

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
        // leanpub-start-insert
        $this->error = null;
        // leanpub-end-insert
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
        // leanpub-start-insert
        $this->storeRecipes();
        // leanpub-end-insert

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
        $this->recipes[$name]['username'] = $user;
        $this->recipes[$name]['rating'] = $rating;
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

    // leanpub-start-insert
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
        $this->recipes[$name]['method'] = $method->getRaw();
    }

    /**
     * @Given the recipe for :name has measured ingredients:
     */
    public function theRecipeForHasMeasuredIngredients($name, TableNode $ingredients)
    {
        $this->recipes[$name]['ingredients'] = [];

        foreach ($ingredients->getHash() as $ingredient) {
            $this->recipes[$name]['ingredients'][] = [
                'name'   => $ingredient['name'],
                'amount' => $ingredient['amount'],
                'unit'   => $ingredient['unit']
            ];
        }
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

    private function storeRecipes()
    {
        foreach ($this->recipes as $name => &$properties) {
            $ingredients = isset($properties['ingredients'])
                ? $properties['ingredients']
                : [];

            $measuredIngredients = array_map(
                function ($ingredient) {
                    return new MeasuredIngredient(
                        Ingredient::fromValues($ingredient['name']),
                        new Amount(
                            $ingredient['amount'],
                            new Unit($ingredient['unit'])
                        )
                    );
                },
                $ingredients
            );

            $method = isset($properties['method'])
                ? $properties['method']
                : '';

            $this->recipeRepository->store(
                new Recipe(
                    new CocktailName($name),
                    new Rating($properties['rating']),
                    User::fromValues($properties['username']),
                    // leanpub-start-insert
                    $measuredIngredients,
                    new Method($method)
                    // leanpub-end-insert
                )
            );

            $properties['id'] = $this->recipeRepository
                                     ->getLastInsertId()
                                     ->getValue();
        }
    }

    /** @return mixed */
    private function getResultField($name)
    {
        $getter = 'get' . ucfirst($name);

        return $this->result->$getter();
    }
    // leanpub-end-insert
}
