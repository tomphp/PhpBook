<?php

namespace spec\CocktailRater\Application\Visitor\Query;

use CocktailRater\Domain\Amount;
use CocktailRater\Domain\CocktailName;
use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\Method;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\RecipeDetails;
use CocktailRater\Domain\Unit;
use CocktailRater\Domain\UserDetails;
use CocktailRater\Domain\Username;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ListRecipesResultDataSpec extends ObjectBehavior
{
    function it_formats_recipes_array()
    {
        $this->beConstructedWith([
            new RecipeDetails(
                new CocktailName('recipe 1'),
                new UserDetails(new Username('user a')),
                new Rating(3),
                new Method('method 1'),
                [
                    new MeasuredIngredient(
                        Ingredient::fromValues('ingredient 1'),
                        Amount::fromValues(4, Unit::ML)
                    )
                ]
            ),
            new RecipeDetails(
                new CocktailName('recipe 2'),
                new UserDetails(new Username('user b')),
                new Rating(5),
                new Method('method 2'),
                []
            )
        ]);

        $this->getRecipes()->shouldReturn([
            [
                'name'   => 'recipe 1',
                'rating' => 3.0,
                'user'   => 'user a',
                'method' => 'method 1',
                'measuredIngredients' => [
                    [
                        'name'   => 'ingredient 1',
                        'amount' => 4,
                        'unit'   => Unit::ML
                    ]
                ]
            ],
            [
                'name'   => 'recipe 2',
                'rating' => 5.0,
                'user'   => 'user b',
                'method' => 'method 2',
                'measuredIngredients' => []
            ]
        ]);
    }
}
