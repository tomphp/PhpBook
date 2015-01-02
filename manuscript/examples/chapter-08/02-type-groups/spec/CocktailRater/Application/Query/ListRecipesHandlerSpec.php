<?php

namespace spec\CocktailRater\Application\Query;

use Assert\Assertion;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Application\Query\ListRecipesQuery;
use CocktailRater\Domain\Repository\RecipeRepository;
use InvalidArgumentException;

class ListRecipesHandlerSpec extends ObjectBehavior
{
    function let(RecipeRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_a_handler()
    {
        $this->shouldBeAnInstanceOf('CocktailRater\Application\Handler');
    }

    function it_only_accepts_ListRecipesQuery(\stdClass $badQuery)
    {
        // Create a version of the exception we want to check for
        try {
            Assertion::isInstanceOf($badQuery->getWrappedObject(), ListRecipesQuery::class);
        } catch (InvalidArgumentException $exception) {
        }

        $this->shouldThrow($exception)->duringHandle($badQuery);
    }

}
