<?php

namespace CocktailRater\Application\Query;

// leanpub-start-insert
use Assert\Assertion;
use CocktailRater\Application\Handler;
// leanpub-end-insert
use CocktailRater\Domain\Repository\RecipeRepository;
use CocktailRater\Domain\Recipe;

// leanpub-start-insert
final class ListRecipesHandler implements Handler
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
     * @param ListRecipesQuery
     *
     * @return ListRecipesResult
     */
    public function handle($query)
    {
        Assertion::isInstanceOf($query, ListRecipesQuery::class);
        // leanpub-end-insert

        return new ListRecipesResultData(
            array_map(function (Recipe $recipe) {
                return $recipe->getDetails();
            },
            $this->getAllRecipesSortedByRating())
        );
    }

    private function getAllRecipesSortedByRating()
    {
        $recipes = $this->repository->findAll();

        usort($recipes, function (Recipe $a, Recipe $b) {
            return $a->isHigherRatedThan($b) ? -1 : 1;
        });

        return $recipes;
    }
}
