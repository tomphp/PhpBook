<?php

namespace CocktailRater\Testing\Repository;

use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\Repository\RecipeRepository;

final class TestRecipeRepository implements RecipeRepository
{
    // leanpub-start-insert
    /** @var Recipe[] */
    private $recipes = [];
    // leanpub-end-insert

    public function store(Recipe $recipe)
    {
        // leanpub-start-insert
        $this->recipes[] = $recipe;
        // leanpub-end-insert
    }

    // leanpub-start-insert
    public function findAll()
    {
        return $this->recipes;
    }
    // leanpub-end-insert

    public function clear()
    {
    }
}
