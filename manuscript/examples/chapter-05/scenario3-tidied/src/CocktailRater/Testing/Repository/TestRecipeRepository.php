<?php

namespace CocktailRater\Testing\Repository;

use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\Repository\RecipeRepository;

final class TestRecipeRepository implements RecipeRepository
{
    /** @var Recipe[] */
    private $recipes = [];

    public function store(Recipe $recipe)
    {
        $this->recipes[] = $recipe;
    }

    public function findAll()
    {
        return $this->recipes;
    }

    public function clear()
    {
    }
}
