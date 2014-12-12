<?php

namespace CocktailRater\Application\Query;

use CocktailRater\Application\Exception\InvalidIdException;
// leanpub-start-insert
use CocktailRater\Application\Handler;
use CocktailRater\Application\Query;
// leanpub-end-insert
use CocktailRater\Domain\RecipeId;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\Repository\Exception\NoSuchEntityException;
use CocktailRater\Domain\Repository\RecipeRepository;

// leanpub-start-insert
final class ViewRecipeHandler implements Handler
// leanpub-end-insert
{
    /** @var RecipeRepository */
    private $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ViewRecipeResult
     *
     * @throws InvalidIdException
     */
    // leanpub-start-insert
    public function handle(ViewRecipeQuery $query)
    // leanpub-end-insert
    {
        return new ViewRecipeResultData(
            $this->findRecipe($query)->getDetails()
        );
    }

    /**
     * @return Recipe
     *
     * @throws InvalidIdException
     */
    private function findRecipe($query)
    {
        try {
            return $this->repository->findById(new RecipeId($query->getId()));
        } catch (NoSuchEntityException $e) {
            throw InvalidIdException::invalidEntityId(
                'Recipe',
                $query->getId(),
                $e
            );
        }
    }
}
