<?php

namespace CocktailRater\Domain\Builder;

use CocktailRater\Domain\Amount;
use CocktailRater\Domain\CocktailName;
use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\Method;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\User;

class RecipeBuilder
{
    /** @var CocktailName */
    private $name;

    /** @var Rating */
    private $rating;

    /** @var User */
    private $user;

    /** @var Method */
    private $method;

    /** @var MeasuredIngredient[] */
    private $ingredients = [];

    public function __construct()
    {
        $this->method = new Method('');
    }

    /** @param string name */
    public function setName(CocktailName $name)
    {
        $this->name = $name;
    }

    public function setRating(Rating $rating)
    {
        $this->rating = $rating;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /** @param string name */
    public function setMethod(Method $method)
    {
        $this->method = $method;
    }

    public function addIngredient(
        Amount $amount,
        Ingredient $ingredient
    ) {
        $this->ingredients[] = new MeasuredIngredient(
            $ingredient,
            $amount
        );
    }

    /** @return Recipe */
    public function build()
    {
        return new Recipe(
            $this->name,
            $this->rating,
            $this->user,
            $this->ingredients,
            $this->method
        );
    }
}
