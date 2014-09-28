<?php

namespace CocktailRater\Testing\Repository;

// leanpub-start-insert
use CocktailRater\Domain\RecipeId;
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
    private $newId = 0;
    // leanpub-end-insert

    public function store(Recipe $recipe)
    {
        // leanpub-start-insert
        $id = 'new id ' . ++$this->newId;

        $this->recipes[$id] = $recipe;
        // leanpub-end-insert
    }

    // leanpub-start-insert
    public function findById(RecipeId $id)
    {
        $key = $id->getValue();

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

    // leanpub-start-insert
    /** @return RecipeId */
    public function getLastInsertId()
    {
        return new RecipeId('new id ' . $this->newId);
    }
    // leanpub-end-insert
}
