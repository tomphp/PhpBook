<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /** @var \Behat\MinkExtension\Context\MinkContext */
    private $minkContext;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @BeforeScenario
     */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();

        $this->minkContext = $environment->getContext(MinkContext::class);
    }

    /**
     * @Given there is a customer named :name with email address :email
     */
    public function thereIsACustomerNamedWithEmailAddress($name, $email)
    {
        // Would contain code to create the customer in the persistent storage
    }

    /**
     * @When I fetch details for customer named :name
     */
    public function iFetchDetailsForCustomerNamed($name)
    {
        $this->minkContext->visit('/show-details/' . $name);
    }

    /**
     * @Then I should see the email address :email
     */
    public function iShouldSeeTheEmailAddress($email)
    {
        $this->minkContext->assertElementContainsText('.email', $email);
    }

    /**
     * @Then I should receiver a not found error
     */
    public function iShouldReceiverANotFoundError()
    {
        $this->minkContext->assertResponseStatus(404);
    }
}
