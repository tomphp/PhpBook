<?php

namespace CocktailRater\Domain\Repository;

use CocktailRater\Domain\Recipe;

interface RecipeRepository
{
    public function add(Recipe $recipe);

    /** @return Recipe[] */
    public function findAll();
}
