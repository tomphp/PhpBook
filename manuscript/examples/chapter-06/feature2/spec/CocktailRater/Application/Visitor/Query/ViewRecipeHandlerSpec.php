<?php

namespace spec\CocktailRater\Application\Visitor\Query;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Application\Visitor\Query\ViewRecipeQuery;
use CocktailRater\Domain\Repository\RecipeRepository;
use CocktailRater\Domain\Identity;
use CocktailRater\Domain\Repository\Exception\NoSuchEntityException;
use CocktailRater\Application\Exception\InvalidIdException;

class ViewRecipeHandlerSpec extends ObjectBehavior
{
    function it_throws_an_exception_for_unknown_id(
        RecipeRepository $repository
    ) {
        $this->beConstructedWith($repository);
        $query = new ViewRecipeQuery('bad id');
        $repository->findById(new Identity('bad id'))
                   ->willThrow(NoSuchEntityException::invalidId('Recipe', new Identity('bad id')));


        $this->shouldThrow(InvalidIdException::invalidEntityId('Recipe', 'bad id'))
             ->duringHandle($query);
    }
}
