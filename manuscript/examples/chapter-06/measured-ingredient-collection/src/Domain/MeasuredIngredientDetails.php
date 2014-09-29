<?php

namespace CocktailRater\Domain;

interface MeasuredIngredientDetails
{
    /** @return string */
    public function getName();

    /** @return float */
    public function getAmount();

    /** @return string */
    public function getUnit();
}
