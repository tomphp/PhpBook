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
    /** @param MeasuredIngredient[] $measuredIngredients */
    public function __construct(
        CocktailName $name,
        Rating $rating,
        User $user,
        array $measuredIngredients,
        Method $method
    ) {
        Assertion::allIsInstanceOf(
            $measuredIngredients,
            MeasuredIngredient::class
        );
        // leanpub-end-insert

        $this->name                = $name;
        $this->rating              = $rating;
        $this->user                = $user;
        // leanpub-start-insert
        $this->method              = $method;
        $this->measuredIngredients = $measuredIngredients;
        // leanpub-end-insert
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
            // leanpub-start-insert
            $this->method,
            $this->measuredIngredients
            // leanpub-end-insert
        );
    }
}
