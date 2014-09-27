<?php

namespace spec\CocktailRater\Domain;

use CocktailRater\Domain\Rating;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Domain\RecipeId;

class RecipeSpec extends ObjectBehavior
{
    function it_is_higher_rated_than_a_recipe_with_a_lower_rating()
    {
        $this->beConstructedWith(
            'test recipe',
            new Rating(3),
            User::fromValues('test user'),
            [],
            ''
        );

        $other = new Recipe(
            'other recipe',
            new Rating(2),
            User::fromValues('test user'),
            [],
            ''
        );

        $this->shouldBeHigherRatedThan($other);
    }

    function it_is_not_higher_rated_than_a_recipe_with_a_higher_rating()
    {
        $this->beConstructedWith(
            'test recipe',
            new Rating(3),
            User::fromValues('test user'),
            [],
            ''
        );

        $other = new Recipe(
            'other recipe',
            new Rating(4),
            User::fromValues('test user'),
            [],
            ''
        );

        $this->shouldNotBeHigherRatedThan($other);
    }
}
