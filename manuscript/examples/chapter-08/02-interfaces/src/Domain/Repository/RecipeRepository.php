<?php

namespace CocktailRater\Domain\Repository;

use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\RecipeId;
use CocktailRater\Domain\Repository\Exception\NoSuchEntityException;

interface RecipeRepository
{
    public function store(Recipe $recipe);

    /**
     * @return Recipe
     *
     * @throws NoSuchEntityException
     */
    public function findById(RecipeId $id);

    /** @return Recipe[] */
    public function findAll();
}
