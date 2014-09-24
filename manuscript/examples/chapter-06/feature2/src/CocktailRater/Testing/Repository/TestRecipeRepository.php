<?php

namespace CocktailRater\Testing\Repository;

// leanpub-start-insert
use CocktailRater\Domain\Identity;
// leanpub-end-insert
use CocktailRater\Domain\Recipe;
// leanpub-start-insert
use CocktailRater\Domain\Repository\Exception\NoSuchEntityException;
// leanpub-end-insert
use CocktailRater\Domain\Repository\RecipeRepository;

final class TestRecipeRepository implements RecipeRepository
{
    /** @var Recipe[] */
    private $recipes = [];

    // leanpub-start-insert
    /** @var int */
    private $newId = 1;
    // leanpub-end-insert

    public function store(Recipe $recipe)
    {
        // leanpub-start-insert
        $key = $recipe->getId()
            ? (string) $recipe->getId()
            : 'new id' . $this->newId++;

        $this->recipes[$key] = $recipe;
        // leanpub-end-insert
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
