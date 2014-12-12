<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
// leanpub-start-insert
use CocktailRater\Application\Query\ListRecipes;
use CocktailRater\Application\Query\ListRecipesHandler;
use CocktailRater\Application\Query\ListRecipesQuery;
use CocktailRater\Application\Query\ListRecipesQueryHandler;
use CocktailRater\Testing\Repository\TestRecipeRepository;
use PHPUnit_Framework_Assert as Assert;
// leanpub-end-insert

/**
 * Behat context class.
 */
class FeatureContext implements SnippetAcceptingContext
{
    // leanpub-start-insert
    /** @var RecipeRepository */
    private $recipeRepository;

    /** @var mixed */
    private $result;
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

    // leanpub-start-insert
    /**
     * @BeforeScenario
     */
    public function beforeScenario()
    {
        $this->recipeRepository = new TestRecipeRepository();
    }
    // leanpub-end-insert

    /**
     * @Given there are no recipes
     */
    public function thereAreNoRecipes()
    {
        // leanpub-start-insert
        $this->recipeRepository->clear();
        // leanpub-end-insert
    }

    /**
     * @When I request a list of recipes
     */
    public function iRequestAListOfRecipes()
    {
        // leanpub-start-insert
        $query = new ListRecipesQuery();
        $handler = new ListRecipesHandler($this->recipeRepository);

        $this->result = $handler->handle($query);
        // leanpub-end-insert
    }

    /**
     * @Then I should see an empty list
     */
    public function iShouldSeeAnEmptyList()
    {
        // leanpub-start-insert
        $recipes = $this->result->getRecipes();

        Assert::assertInternalType('array', $recipes);
        Assert::assertEmpty($recipes);
        // leanpub-end-insert
    }

    /**
     * @Given there's a recipe for :arg1 by user :arg2 with :arg3 stars
     */
    public function theresARecipeForByUserWithStars($arg1, $arg2, $arg3)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see a list of recipes containing:
     */
    public function iShouldSeeAListOfRecipesContaining(TableNode $table)
    {
        throw new PendingException();
    }
}
