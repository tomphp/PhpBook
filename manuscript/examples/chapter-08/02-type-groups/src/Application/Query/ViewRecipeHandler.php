<?php

namespace CocktailRater\Application\Query;

// leanpub-start-insert
use Assert\Assertion;
// leanpub-end-insert
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

    // leanpub-start-insert
    /**
     * @param ViewRecipeQuery $query
     *
     * @return ViewRecipeResult
     *
     * @throws InvalidIdException
     */
    public function handle(Query $query)
    {
        Assertion::isInstanceOf($query, ViewRecipeQuery::class);
        // leanpub-end-insert

        return new ViewRecipeResultData(
            $this->findRecipe($query)->getDetails()
        );
    }

    /**
     * @return Recipe
     *
     * @throws InvalidIdException
     */
    private function findRecipe(ViewRecipeQuery $query)
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
