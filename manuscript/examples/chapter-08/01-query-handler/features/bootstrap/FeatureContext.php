<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use CocktailRater\Application\Exception\ApplicationException;
use CocktailRater\Application\Query\ListRecipesQuery;
use CocktailRater\Application\Query\ViewRecipeQuery;
use CocktailRater\Application\QueryHandler;
use CocktailRater\Domain\Builder\RecipeBuilder;
use CocktailRater\Domain\RecipeId;
use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\Amount;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\CocktailName;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\Method;
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

        // leanpub-start-insert
        $this->handleQuery(new ListRecipesQuery());
        // leanpub-end-insert
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
        $builder = $this->getRecipeBuilder($name);

        $builder->setUser(User::fromValues($user));
        $builder->setRating(new Rating($rating));
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
     * @When I request to view recipe for :name
     */
    public function iRequestToViewRecipeFor($name)
    {
        $this->storeRecipes();

        // leanpub-start-insert
        $this->handleQuery(new ViewRecipeQuery($this->recipes[$name]['id']));
        // leanpub-end-insert
    }

    /**
     * @Given the recipe for :name has method:
     */
    public function theRecipeForHasMethod($name, PyStringNode $method)
    {
        $this->getRecipeBuilder($name)->setMethod(
            new Method($method->getRaw())
        );
    }

    /**
     * @Given the recipe for :name has measured ingredients:
     */
    public function theRecipeForHasMeasuredIngredients(
        $name,
        TableNode $ingredients
    ) {
        $builder = $this->getRecipeBuilder($name);

        foreach ($ingredients->getHash() as $ingredient) {
            $builder->addIngredient(
                Amount::fromValues(
                    $ingredient['amount'],
                    $ingredient['unit']
                ),
                Ingredient::fromValues($ingredient['name'])
            );
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
    public function iShouldSeeAListOfMeasuredIngredientsContaining(
        TableNode $table
    ) {
        Assert::assertEquals(
            $table->getHash(),
            $this->getResultField('measuredIngredients')
        );
    }

    /**
     * @param string $name
     *
     * @return RecipeBuilder
     */
    private function getRecipeBuilder($name)
    {
        if (!isset($this->recipes[$name])) {
            $this->recipes[$name]['builder'] = new RecipeBuilder();
            $this->recipes[$name]['builder']->setName(new CocktailName($name));
        }

        return $this->recipes[$name]['builder'];
    }

    private function storeRecipes()
    {
        foreach ($this->recipes as $name => &$recipeSpec) {
            $recipe = $recipeSpec['builder']->build();

            $this->recipeRepository->store($recipe);

            $recipeSpec['id'] = $this->recipeRepository
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

    // leanpub-start-insert
    private function handleQuery($query)
    {
        $handler = new QueryHandler($this->recipeRepository);

        $this->result = $handler->handle($query);
    }
    // leanpub-end-insert
}
