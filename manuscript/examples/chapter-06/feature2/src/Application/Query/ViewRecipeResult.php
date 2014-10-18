<?php

namespace CocktailRater\Application\Query;

interface ViewRecipeResult
{
    /** @return string */
    public function getName();

    /** @return string */
    public function getUsername();

    /** @return float */
    public function getRating();

    /** @return string */
    public function getMethod();

    /** @return array */
    public function getMeasuredIngredients();
}
