<?php

namespace spec\CocktailRater\Domain\Builder;

use CocktailRater\Domain\Amount;
use CocktailRater\Domain\CocktailName;
use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\Method;
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
        $this->setName(new CocktailName('test recipe'));
        $this->setRating(new Rating(3));
        $this->setUser(User::fromValues('test user'));
        $this->setMethod(new Method('test method'));
        $this->addIngredient(
            Amount::fromValues(10, Unit::ML),
            Ingredient::fromValues('ingredient 1')
        );
        $this->addIngredient(
            Amount::fromValues(50, Unit::ML),
            Ingredient::fromValues('ingredient 2')
        );

        $this->build()->shouldBeLike(
            new Recipe(
                new CocktailName('test recipe'),
                new Rating(3),
                User::fromValues('test user'),
                [
                    new MeasuredIngredient(
                        Ingredient::fromValues('ingredient 1'),
                        Amount::fromValues(10, Unit::ML)
                    ),
                    new MeasuredIngredient(
                        Ingredient::fromValues('ingredient 2'),
                        Amount::fromValues(50, Unit::ML)
                    )
                ],
                new Method('test method')
            )
        );
    }
}
