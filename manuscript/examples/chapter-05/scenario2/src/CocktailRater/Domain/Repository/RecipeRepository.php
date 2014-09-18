<?php

namespace CocktailRater\Domain\Repository;

use CocktailRater\Domain\Recipe;

interface RecipeRepository
{
    public function add(Recipe $recipe);

    // leanpub-start-insert
    /** @return Recipe[] */
    public function findAll();
    // leanpub-end-insert
}
