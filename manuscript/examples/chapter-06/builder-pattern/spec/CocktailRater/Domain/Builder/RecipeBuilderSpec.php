<?php

namespace spec\CocktailRater\Domain\Builder;

use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\IngredientAmount;
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
            IngredientAmount::fromValues(10, 'ml'),
            new Ingredient('ingredient 1')
        );
        $this->addIngredient(
            IngredientAmount::fromValues(50, 'ml'),
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
                        IngredientAmount::fromValues(10, 'ml')
                    ),
                    new MeasuredIngredient(
                        new Ingredient('ingredient 2'),
                        IngredientAmount::fromValues(50, 'ml')
                    )
                ],
                'test method'
            )
        );
    }
}
