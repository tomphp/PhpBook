<?php

namespace spec\CocktailRater\Application;

use CocktailRater\Application\Exception\NoMatchingHandlerException;
use CocktailRater\Application\Exception\NotAHandlerException;
use CocktailRater\Application\Handler;
use CocktailRater\Application\Query;
use CocktailRater\Application\Result;
use CocktailRater\Domain\Repository\RecipeRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QueryHandlerSpec extends ObjectBehavior
{
    function let(RecipeRepository $recipeRepository)
    {
        $this->beConstructedWith($recipeRepository);
    }

    function it_throws_if_class_is_not_a_query()
    {
        $this->shouldThrow(new \InvalidArgumentException())
             ->duringHandle(new BadlyNamed());
    }

    function it_throws_if_no_matching_handler_is_found()
    {
        $this->shouldThrow(NoMatchingHandlerException::notFound(
            MissingHandlerQuery::class,
            __NAMESPACE__ . '\MissingHandlerHandler'
        ))->duringHandle(new MissingHandlerQuery());
    }

    function it_throws_if_handler_is_not_a_handler()
    {
        $this->shouldThrow(NotAHandlerException::missingHandleMethod(
            BadHandlerHandler::class
        ))->duringHandle(new BadHandlerQuery());
    }

    function it_handles_a_query()
    {
        $query = new GoodQuery();

        $this->handle($query)->isFor($query)->shouldBe(true);
    }
}

class BadlyNamed implements Query
{
}

class MissingHandlerQuery implements Query
{
}

class BadHandlerQuery implements Query
{
}

class BadHandlerHandler
{
}

class GoodQuery implements Query
{
}

class GoodHandler implements Handler
{
    public function handle(Query $query)
    {
        return new GoodResult($query);
    }
}

class GoodResult implements Result
{
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function isFor($query)
    {
        return spl_object_hash($query) === spl_object_hash($this->query);
    }
}