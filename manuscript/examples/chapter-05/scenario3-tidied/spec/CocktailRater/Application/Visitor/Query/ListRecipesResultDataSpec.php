<?php

namespace spec\CocktailRater\Application\Visitor\Query;

use CocktailRater\Domain\CocktailName;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\RecipeDetails;
use CocktailRater\Domain\UserDetails;
use CocktailRater\Domain\Username;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ListRecipesResultDataSpec extends ObjectBehavior
{
    function it_can_add_recipes_details()
    {
        $this->beConstructedWith([
            new RecipeDetails(
                new CocktailName('recipe 1'),
                new UserDetails(new Username('user a')),
                new Rating(3)
            ),
            new RecipeDetails(
                new CocktailName('recipe 2'),
                new UserDetails(new Username('user b')),
                new Rating(5)
            )
        ]);

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
