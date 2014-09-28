<?php

namespace spec\CocktailRater\Domain;

use CocktailRater\Domain\Amount;
use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\RecipeId;
use CocktailRater\Domain\Unit;
use CocktailRater\Domain\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RecipeSpec extends ObjectBehavior
{
    const RECIPE_NAME       = 'test recipe';
    const RECIPE_RATING     = 3.0;
    const RECIPE_USERNAME   = 'test_user';
    const RECIPE_METHOD     = 'test method';
    const INGREDIENT_NAME   = 'test ingredient 1';
    const INGREDIENT_AMOUNT = 1;
    const INGREDIENT_UNIT   = 'fl oz';

    function let()
    {
        $this->beConstructedWith(
            self::RECIPE_NAME,
            new Rating(self::RECIPE_RATING),
            User::fromValues(self::RECIPE_USERNAME),
            [new MeasuredIngredient(
                new Ingredient(self::INGREDIENT_NAME),
                Amount::fromValues(self::INGREDIENT_AMOUNT, self::INGREDIENT_UNIT)
            )],
            self::RECIPE_METHOD
        );
    }

    function it_is_higher_rated_than_a_recipe_with_a_lower_rating()
    {
        $other = new Recipe(
            'other recipe',
            new Rating(2),
            User::fromValues(self::RECIPE_USERNAME),
            [],
            ''
        );

        $this->shouldBeHigherRatedThan($other);
    }

    function it_is_not_higher_rated_than_a_recipe_with_a_higher_rating()
    {
        $other = new Recipe(
            'other recipe',
            new Rating(4),
            User::fromValues(self::RECIPE_USERNAME),
            [],
            ''
        );

        $this->shouldNotBeHigherRatedThan($other);
    }

    function it_returns_recipe_details()
    {
        $details = $this->getDetails();

        $details->getName()->shouldReturn(self::RECIPE_NAME);
        $details->getUsername()->shouldReturn(self::RECIPE_USERNAME);
        $details->getRating()->shouldReturn(self::RECIPE_RATING);
        $details->getMethod()->shouldReturn(self::RECIPE_METHOD);
        $details->getMeasuredIngredients()->shouldReturn([
            [
                'name'   => self::INGREDIENT_NAME,
                'amount' => self::INGREDIENT_AMOUNT,
                'unit'   => self::INGREDIENT_UNIT
            ]
        ]);
    }
}
