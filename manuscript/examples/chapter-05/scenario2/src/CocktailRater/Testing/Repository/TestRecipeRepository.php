<?php

namespace CocktailRater\Testing\Repository;

// leanpub-start-insert
use CocktailRater\Domain\Recipe;
// leanpub-end-insert
use CocktailRater\Domain\Repository\RecipeRepository;

final class TestRecipeRepository implements RecipeRepository
{
    // leanpub-start-insert
    /** @var Recipe[] */
    private $recipes = [];

    public function add(Recipe $recipe)
    {
        $this->recipes[] = $recipe;
    }

    public function findAll()
    {
        return $this->recipes;
    }
    // leanpub-end-insert

    public function clear()
    {
    }
}
