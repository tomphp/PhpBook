<?php

namespace CocktailRater\Domain;

use Assert\Assertion;

final class Recipe
{
    /** @var CocktailName */
    private $name;

    /** @var Rating */
    private $rating;

    /** @var User */
    private $user;

    /** @var MeasuredIngredient[] */
    private $measuredIngredients;

    /** @var Method */
    private $method;

    // leanpub-start-insert
    public function __construct(
        CocktailName $name,
        Rating $rating,
        User $user,
        MeasuredIngredients $measuredIngredients,
        Method $method
    ) {
    // leanpub-end-insert
        $this->name                = $name;
        $this->rating              = $rating;
        $this->user                = $user;
        $this->method              = $method;
        $this->measuredIngredients = $measuredIngredients;
    }

    /** @return bool */
    public function isHigherRatedThan(Recipe $other)
    {
        return $this->rating->isHigherThan($other->rating);
    }

    /** @return RecipeDetails */
    public function getDetails()
    {
        return new RecipeDetails(
            $this->name,
            $this->user->getDetails(),
            $this->rating,
            $this->method,
            // leanpub-start-insert
            $this->measuredIngredients->getDetails()
            // leanpub-end-insert
        );
    }
}
