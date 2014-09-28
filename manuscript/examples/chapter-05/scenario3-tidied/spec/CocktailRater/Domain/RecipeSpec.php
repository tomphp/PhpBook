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
    const RECIPE_NAME       = 'test recipe';
    const RECIPE_RATING     = 3.0;
    const RECIPE_USERNAME   = 'test_user';

    function let()
    {
        $this->beConstructedWith(
            new CocktailName(self::RECIPE_NAME),
            new Rating(self::RECIPE_RATING),
            User::fromValues(self::RECIPE_USERNAME)
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

    function it_returns_recipe_details()
    {
        $details = $this->getDetails();

        $details->shouldBeAnInstanceOf('CocktailRater\Domain\RecipeDetails');

        $details->getName()->shouldReturn(self::RECIPE_NAME);
        $details->getUsername()->shouldReturn(self::RECIPE_USERNAME);
        $details->getRating()->shouldReturn(self::RECIPE_RATING);
    }
}
