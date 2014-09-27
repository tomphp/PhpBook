<?php

namespace CocktailRater\Domain;

final class MeasuredIngredient
{
    /** @var Ingredient */
    private $ingredient;

    /** @var IngredientAmount */
    private $amount;

    public function __construct(
        Ingredient $ingredient,
        IngredientAmount $amount
    ) {
        $this->ingredient = $ingredient;
        $this->amount     = $amount;
    }

    /** @return Ingredient */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /** @return IngredientAmount */
    public function getAmount()
    {
        return $this->amount;
    }
}
