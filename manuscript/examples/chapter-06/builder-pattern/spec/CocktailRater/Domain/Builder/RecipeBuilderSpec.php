<?php

namespace spec\CocktailRater\Domain\Builder;

use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\Amount;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\Unit;
use CocktailRater\Domain\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RecipeBuilderSpec extends ObjectBehavior
{
    function it_builds_a_Recipe()
    {
        $this->setName('test recipe');
        $this->setRating(new Rating(3));
        $this->setUser(User::fromValues('test user'));
        $this->setMethod('test method');
        $this->addIngredient(
            Amount::fromValues(10, Unit::ML),
            new Ingredient('ingredient 1')
        );
        $this->addIngredient(
            Amount::fromValues(50, Unit::ML),
            new Ingredient('ingredient 2')
        );

        $this->build()->shouldBeLike(
            new Recipe(
                'test recipe',
                new Rating(3),
                User::fromValues('test user'),
                [
                    new MeasuredIngredient(
                        new Ingredient('ingredient 1'),
                        Amount::fromValues(10, Unit::ML)
                    ),
                    new MeasuredIngredient(
                        new Ingredient('ingredient 2'),
                        Amount::fromValues(50, Unit::ML)
                    )
                ],
                'test method'
            )
        );
    }
}
