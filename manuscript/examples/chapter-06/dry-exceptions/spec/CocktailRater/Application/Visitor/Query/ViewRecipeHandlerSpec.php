<?php

namespace spec\CocktailRater\Application\Visitor\Query;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Application\Visitor\Query\ViewRecipeQuery;
use CocktailRater\Domain\Repository\RecipeRepository;
use CocktailRater\Domain\RecipeId;
use CocktailRater\Domain\Repository\Exception\NoSuchEntityException;
use CocktailRater\Application\Exception\InvalidIdException;

class ViewRecipeHandlerSpec extends ObjectBehavior
{
    function it_throws_an_exception_for_unknown_id(
        RecipeRepository $repository
    ) {
        $this->beConstructedWith($repository);
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
