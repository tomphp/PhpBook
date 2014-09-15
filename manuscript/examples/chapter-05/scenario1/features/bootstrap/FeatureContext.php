<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
// leanpub-start-insert
use CocktailRater\Application\Visitor\Query\ListRecipes;
use CocktailRater\Application\Visitor\Query\ListRecipesHandler;
use CocktailRater\Application\Visitor\Query\ListRecipesQuery;
use CocktailRater\Application\Visitor\Query\ListRecipesQueryHandler;
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
     * @Given there is a recipe called :arg1 with a rating of :arg3 submitted by :arg2
     */
    public function thereIsARecipeCalledWithARatingOfSubmittedBy($arg1, $arg2, $arg3)
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