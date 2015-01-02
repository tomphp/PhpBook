<?php

namespace spec\CocktailRater\Application\Query;

use Assert\Assertion;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Application\Query;
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
        $this->beConstructedWith($repository);
    }

    function it_is_a_handler()
    {
        $this->shouldBeAnInstanceOf('CocktailRater\Application\Handler');
    }

    function it_only_accepts_ViewRecipeQuery(Query $badQuery)
    {
        // Create a version of the exception we want to check for
        try {
            Assertion::isInstanceOf($badQuery->getWrappedObject(), ViewRecipeQuery::class);
        } catch (InvalidArgumentException $exception) {
        }

        $this->shouldThrow($exception)->duringHandle($badQuery);
    }

    function it_throws_an_exception_for_unknown_id($repository)
    {
        $query = new ViewRecipeQuery('bad id');
        $repoException = NoSuchEntityException::invalidId(
            'Recipe',
            new RecipeId('bad id')
        );
        $repository->findById(new RecipeId('bad id'))->willThrow($repoException);

        $this->shouldThrow(
            InvalidIdException::invalidEntityId('Recipe', 'bad id', $repoException)
        )->duringHandle($query);
    }
}
