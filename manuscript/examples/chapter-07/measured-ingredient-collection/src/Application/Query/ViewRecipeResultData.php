<?php

namespace CocktailRater\Application\Query;

use CocktailRater\Domain\RecipeDetails;

final class ViewRecipeResultData implements ViewRecipeResult
{
    /** @var RecipeDetails */
    private $recipe;

    public function __construct(RecipeDetails $recipe)
    {
        $this->recipe = $recipe;
    }

    /** @return string */
    public function getName()
    {
        return $this->recipe->getName();
    }

    /** @return string */
    public function getUsername()
    {
        return $this->recipe->getUsername();
    }

    /** @return float */
    public function getRating()
    {
        return $this->recipe->getRating();
    }

    /** @return string */
    public function getMethod()
    {
        return $this->recipe->getMethod();
    }

    /** @return array */
    public function getMeasuredIngredients()
    {
        return $this->recipe->getMeasuredIngredients();
    }
}
