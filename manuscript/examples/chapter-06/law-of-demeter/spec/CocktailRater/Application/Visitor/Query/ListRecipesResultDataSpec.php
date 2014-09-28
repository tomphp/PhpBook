<?php

namespace spec\CocktailRater\Application\Visitor\Query;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Domain\RecipeDetails;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\UserDetails;

class ListRecipesResultDataSpec extends ObjectBehavior
{
    function it_starts_with_an_empty_list_of_recipes()
    {
        $this->getRecipes()->shouldReturn([]);
    }

    function it_can_add_recipes_details()
    {
        $this->addRecipe(
            new RecipeDetails(
                'recipe 1',
                new UserDetails('user a'),
                3.0,
                '',
                []
            )
        );

        $this->addRecipe(
            new RecipeDetails(
                'recipe 2',
                new UserDetails('user b'),
                5.0,
                '',
                []
            )
        );

        $this->getRecipes()->shouldReturn([
            [
                'name'   => 'recipe 1',
                'rating' => 3.0,
                'user'   => 'user a'
            ],
            [
                'name'   => 'recipe 2',
                'rating' => 5.0,
                'user'   => 'user b'
            ]
        ]);
    }
}
