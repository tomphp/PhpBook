<?php

namespace CocktailRater\Domain\Repository;

use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\RecipeId;
use CocktailRater\Domain\Repository\Exception\NoSuchEntityException;

interface RecipeRepository
{
    public function store(Recipe $recipe);

    // leanpub-start-insert
    /**
     * @return Recipe
     *
     * @throws NoSuchEntityException
     */
    public function findById(RecipeId $id);
    // leanpub-end-insert

    /** @return Recipe[] */
    public function findAll();
}
