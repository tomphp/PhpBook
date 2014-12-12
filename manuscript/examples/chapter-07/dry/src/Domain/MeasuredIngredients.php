<?php

namespace CocktailRater\Domain;

final class MeasuredIngredients
{
    /** @var MeasuredIngredient[] */
    private $measuredIngredients;

    /** @param MeasuredIngredient[] $measuredIngredients */
    public function __construct(array $measuredIngredients)
    {
        $this->measuredIngredients = $measuredIngredients;
    }

    /** @return MeasuredIngredientDetails[] */
    public function getDetails()
    {
        return $this->measuredIngredients;
    }
}
