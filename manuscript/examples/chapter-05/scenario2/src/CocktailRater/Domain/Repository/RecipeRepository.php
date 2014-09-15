<?php

namespace CocktailRater\Domain\Repository;

use CocktailRater\Domain\Recipe;

interface RecipeRepository
{
    // leanpub-start-insert
    public function add(Recipe $recipe);

    /** @return Recipe[] */
    public function findAll();
    // leanpub-end-insert
}
