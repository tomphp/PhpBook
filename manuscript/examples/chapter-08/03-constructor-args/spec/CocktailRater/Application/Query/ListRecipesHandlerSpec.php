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
        $this->beConstructedWith(
            new ListRecipesQuery(),
            $repository
        );
    }

    function it_is_a_handler()
    {
        $this->shouldBeAnInstanceOf('CocktailRater\Application\Handler');
    }
}
