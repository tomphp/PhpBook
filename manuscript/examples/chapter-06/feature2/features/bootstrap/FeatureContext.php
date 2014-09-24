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
use CocktailRater\Domain\Identity;
use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\IngredientAmount;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\Recipe;
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
        $this->recipeRepository->store(
            new Recipe(
                $name,
                new Rating($rating),
                new User(new Username($user)),
                [],
                ''
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

    // leanpub-start-insert
    /**
     * @When I request to view recipe :id
     */
    public function iRequestToViewRecipe($id)
    {
        foreach ($this->recipes as $name => $properties) {
            $measuredIngredients = array_map(
                function ($ingredient) {
                    return new MeasuredIngredient(
                        new Ingredient($ingredient['name']),
                        new IngredientAmount(
                            $ingredient['amount'],
                            new Unit($ingredient['unit'])
                        )
                    );
                },
                $properties['ingredients']
            );

            $this->recipeRepository->store(
                new Recipe(
                    $name,
                    new Rating($properties['rating']),
                    User::fromValues($properties['username']),
                    $measuredIngredients,
                    $properties['method'],
                    new Identity($properties['id'])
                )
            );
        }

        try {
            $query = new ViewRecipeQuery($id);
            $handler = new ViewRecipeHandler($this->recipeRepository);

            $this->result = $handler->handle($query);
        } catch (ApplicationException $e) {
            $this->error = $e;
        }
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
     * @Given there's a recipe for :name with id :id
     */
    public function thereSARecipeForWithId($name, $id)
    {
        $this->recipes[$name]['id'] = $id;
    }

    /**
     * @Given the recipe for :name was submitted by user :username
     */
    public function theRecipeForWasSubmittedByUser($name, $username)
    {
        $this->recipes[$name]['username'] = $username;
    }

    /**
     * @Given the recipe for :name is rated with :rating stars
     */
    public function theRecipeForIsRatedWithStars($name, $rating)
    {
        $this->recipes[$name]['rating'] = $rating;
    }

    /**
     * @Given the recipe for :name has method:
     */
    public function theRecipeForHasMethod($name, PyStringNode $method)
    {
        $this->recipes[$name]['method'] = $method;
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

    /** @return mixed */
    private function getResultField($name)
    {
        $getter = 'get' . ucfirst($name);

        return $this->result->$getter();
    }
    // leanpub-end-insert
}
