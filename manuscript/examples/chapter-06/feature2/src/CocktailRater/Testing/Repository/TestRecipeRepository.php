<?php

namespace CocktailRater\Testing\Repository;

use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\Repository\RecipeRepository;
use CocktailRater\Domain\Identity;
use CocktailRater\Domain\Repository\Exception\NoSuchEntityException;

final class TestRecipeRepository implements RecipeRepository
{
    /** @var Recipe[] */
    private $recipes = [];

    /** @var int */
    private $newId = 1;

    public function store(Recipe $recipe)
    {
        $key = $recipe->getId()
            ? (string) $recipe->getId()
            : 'new id' . $this->newId++;

        $this->recipes[$key] = $recipe;
    }

    // leanpub-start-insert
    public function findById(Identity $id)
    {
        $key = (string) $id;

        if (!array_key_exists($key, $this->recipes)) {
            throw NoSuchEntityException::invalidId('Recipe', $id);
        }

        return $this->recipes[$key];
    }
    // leanpub-end-insert

    public function findAll()
    {
        return $this->recipes;
    }

    public function clear()
    {
    }
}
