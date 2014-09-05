<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use BehatExample\BookList;

/**
 * Behat context class.
 */
class FeatureContext implements SnippetAcceptingContext
{
    /** @var BookList */
    private $bookList;

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
        $this->bookList = new BookList();
    }

    /**
     * @Given there are no books
     */
    public function thereAreNoBooks()
    {
        $this->bookList->clear();
    }

    /**
     * @When I list all books
     */
    public function iListAllBooks()
    {
        $this->result = $this->bookList->getBooks();
    }

    /**
     * @Then I should see an empty list
     */
    public function iShouldSeeAnEmptyList()
    {
        if ([] !== $this->result) {
            throw new Exception('Result was incorrect.');
        }
    }

    /**
     * @Given there is a book called :title by :author
     */
    public function thereIsABookCalledBy($title, $author)
    {
        $this->bookList->add($title, $author);
    }

    /**
     * @Then I should see:
     */
    public function iShouldSee(TableNode $table)
    {
        if ($table->getHash() !== $this->result) {
            throw new Exception('Result was incorrect.');
        }
    }
}
