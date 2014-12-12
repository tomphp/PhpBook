<?php

namespace spec\CocktailRater\Application;

use CocktailRater\Application\Exception\NoMatchingHandlerException;
use CocktailRater\Application\Exception\NotAHandlerException;
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
             ->duringHandle(new \stdClass());
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
            NoHandleMethodHandler::class
        ))->duringHandle(new NoHandleMethodQuery());
    }

    function it_handles_a_query()
    {
        $query = new GoodQuery();

        $this->handle($query)->isFor($query)->shouldBe(true);
    }
}

class MissingHandlerQuery
{
}

class NoHandleMethodQuery
{
}

class NoHandleMethodHandler
{
}

class GoodQuery
{
}

class GoodHandler
{
    public function handle($query)
    {
        return new GoodResult($query);
    }
}

class GoodResult
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
