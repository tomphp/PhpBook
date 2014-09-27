<?php

namespace CocktailRater\Domain;

final class MeasuredIngredient
{
    /** @var Ingredient */
    private $ingredient;

    /** @var Amount */
    private $amount;

    public function __construct(
        Ingredient $ingredient,
        Amount $amount
    ) {
        $this->ingredient = $ingredient;
        $this->amount     = $amount;
    }

    /** @return Ingredient */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /** @return Amount */
    public function getAmount()
    {
        return $this->amount;
    }
}
