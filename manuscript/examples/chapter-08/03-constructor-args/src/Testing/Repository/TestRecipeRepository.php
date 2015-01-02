<?php

namespace CocktailRater\Testing\Repository;

use CocktailRater\Domain\RecipeId;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\Repository\Exception\NoSuchEntityException;
use CocktailRater\Domain\Repository\RecipeRepository;

final class TestRecipeRepository implements RecipeRepository
{
    /** @var Recipe[] */
    private $recipes = [];

    /** @var int */
    private $newId = 0;

    public function store(Recipe $recipe)
    {
        $id = 'new id ' . ++$this->newId;

        $this->recipes[$id] = $recipe;
    }

    public function findById(RecipeId $id)
    {
        $key = $id->getValue();

        if (!array_key_exists($key, $this->recipes)) {
            throw NoSuchEntityException::invalidId('Recipe', $id);
        }

        return $this->recipes[$key];
    }

    public function findAll()
    {
        return $this->recipes;
    }

    public function clear()
    {
    }

    /** @return RecipeId */
    public function getLastInsertId()
    {
        return new RecipeId('new id ' . $this->newId);
    }
}
