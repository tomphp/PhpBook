<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Behat context class.
 */
class FeatureContext implements SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given there are no recipes
     */
    public function thereAreNoRecipes()
    {
        throw new PendingException();
    }

    /**
     * @When I request a list of recipes
     */
    public function iRequestAListOfRecipes()
    {
        throw new PendingException();
    }

    /**
     * @Then I should see an empty list
     */
    public function iShouldSeeAnEmptyList()
    {
        throw new PendingException();
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
