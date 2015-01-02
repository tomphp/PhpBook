<?php

namespace CocktailRater\Application\Query;

use Assert\Assertion;
use CocktailRater\Application\Exception\InvalidIdException;
use CocktailRater\Application\Handler;
use CocktailRater\Domain\RecipeId;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\Repository\Exception\NoSuchEntityException;
use CocktailRater\Domain\Repository\RecipeRepository;

final class ViewRecipeHandler implements Handler
{
    // leanpub-start-insert
    /** @var ViewRecipeQuery */
    private $query;
    // leanpub-end-insert

    /** @var RecipeRepository */
    private $repository;

    // leanpub-start-insert
    public function __construct(
        ViewRecipeQuery $query,
        RecipeRepository $repository
    ) {
        $this->query      = $query;
        // leanpub-end-insert
        $this->repository = $repository;
    }

    // leanpub-start-insert
    /**
     * @return ViewRecipeResult
     *
     * @throws InvalidIdException
     */
    public function handle()
    {
        return new ViewRecipeResultData($this->findRecipe()->getDetails());
    }
    // leanpub-end-insert

    /**
     * @return Recipe
     *
     * @throws InvalidIdException
     */
    // leanpub-start-insert
    private function findRecipe()
    // leanpub-end-insert
    {
        try {
            // leanpub-start-insert
            return $this->repository->findById(
                new RecipeId($this->query->getId())
            );
            // leanpub-end-insert
        } catch (NoSuchEntityException $e) {
            throw InvalidIdException::invalidEntityId(
                'Recipe',
                // leanpub-start-insert
                $this->query->getId(),
                // leanpub-end-insert
                $e
            );
        }
    }
}
