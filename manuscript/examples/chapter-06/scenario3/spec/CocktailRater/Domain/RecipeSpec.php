<?php

namespace spec\CocktailRater\Domain;

use CocktailRater\Domain\CocktailName;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RecipeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            new CocktailName('test recipe'),
            new Rating(3),
            User::fromValues('test user')
        );

    }

    function it_is_higher_rated_than_a_recipe_with_a_lower_rating()
    {
        $other = new Recipe(
            new CocktailName('other recipe'),
            new Rating(2),
            User::fromValues('test user')
        );

        $this->shouldBeHigherRatedThan($other);
    }

    function it_is_not_higher_rated_than_a_recipe_with_a_higher_rating()
    {
        $other = new Recipe(
            new CocktailName('other recipe'),
            new Rating(4),
            User::fromValues('test user')
        );

        $this->shouldNotBeHigherRatedThan($other);
    }
}
