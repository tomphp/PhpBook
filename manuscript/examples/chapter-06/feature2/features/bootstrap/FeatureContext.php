<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use CocktailRater\Application\Visitor\Query\ListRecipes;
use CocktailRater\Application\Visitor\Query\ListRecipesHandler;
use CocktailRater\Application\Visitor\Query\ListRecipesQuery;
use CocktailRater\Application\Visitor\Query\ListRecipesQueryHandler;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\Recipe;
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
        $this->recipeRepository->add(
            new Recipe(
                $name,
                new Rating($rating),
                new User(new Username($user))
            )
        );
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
     * @When I request to view recipe :arg1
     */
    public function iRequestToViewRecipe($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see an invalid id error
     */
    public function iShouldSeeAnInvalidIdError()
    {
        throw new PendingException();
    }

    /**
     * @Given there's a recipe for :arg1 with id :arg2
     */
    public function thereSARecipeForWithId($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Given the recipe for :arg1 was submitted by user :arg2
     */
    public function theRecipeForWasSubmittedByUser($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Given the recipe for :arg1 is rated with :arg2 stars
     */
    public function theRecipeForIsRatedWithStars($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Given the recipe for :arg1 has directions:
     */
    public function theRecipeForHasDirections($arg1, PyStringNode $string)
    {
        throw new PendingException();
    }

    /**
     * @Given the recipe for :arg1 has ingredients:
     */
    public function theRecipeForHasIngredients($arg1, TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see a field :arg1 with value of :arg2
     */
    public function iShouldSeeAFieldWithValueOf($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see a file :arg1 with value:
     */
    public function iShouldSeeAFileWithValue($arg1, PyStringNode $string)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see a list of ingredients containing:
     */
    public function iShouldSeeAListOfIngredientsContaining(TableNode $table)
    {
        throw new PendingException();
    }
}
