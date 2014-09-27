<?php

namespace CocktailRater\Domain\Builder;

use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\IngredientAmount;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\User;

class RecipeBuilder
{
    /** @var string */
    private $name;

    /** @var Rating */
    private $rating;

    /** @var User */
    private $user;

    /** @var string */
    private $method = '';

    /** @var MeasuredIngredient[] */
    private $ingredients = [];

    /** @param string name */
    public function setName($name)
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
    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function addIngredient(
        IngredientAmount $amount,
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
