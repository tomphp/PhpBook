<?php

namespace CocktailRater\Domain\Repository;

use CocktailRater\Domain\Recipe;

interface RecipeRepository
{
    public function store(Recipe $recipe);

    /** @return Recipe[] */
    public function findAll();
}
