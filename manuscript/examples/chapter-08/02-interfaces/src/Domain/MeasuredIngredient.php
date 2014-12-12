<?php

namespace CocktailRater\Domain;

final class MeasuredIngredient implements MeasuredIngredientDetails
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

    public function getName()
    {
        return $this->ingredient->getName();
    }

    public function getAmount()
    {
        return $this->amount->getValue();
    }

    public function getUnit()
    {
        return $this->amount->getUnit();
    }
}
