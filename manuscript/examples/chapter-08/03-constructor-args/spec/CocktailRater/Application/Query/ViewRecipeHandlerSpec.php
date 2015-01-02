<?php

namespace spec\CocktailRater\Application\Query;

use Assert\Assertion;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Application\Query\ViewRecipeQuery;
use CocktailRater\Domain\Repository\RecipeRepository;
use CocktailRater\Domain\RecipeId;
use CocktailRater\Domain\Repository\Exception\NoSuchEntityException;
use CocktailRater\Application\Exception\InvalidIdException;
use InvalidArgumentException;

class ViewRecipeHandlerSpec extends ObjectBehavior
{
    function let(RecipeRepository $repository)
    {
        $this->beConstructedWith(new ViewRecipeQuery('test id'), $repository);
    }

    function it_is_a_handler()
    {
        $this->shouldBeAnInstanceOf('CocktailRater\Application\Handler');
    }

    function it_throws_an_exception_for_unknown_id($repository)
    {
        $this->beConstructedWith(new ViewRecipeQuery('bad id'), $repository);

        $repoException = NoSuchEntityException::invalidId(
            'Recipe',
            new RecipeId('bad id')
        );

        $repository->findById(new RecipeId('bad id'))->willThrow($repoException);

        $this->shouldThrow(
            InvalidIdException::invalidEntityId('Recipe', 'bad id', $repoException)
        )->duringHandle();
    }
}
