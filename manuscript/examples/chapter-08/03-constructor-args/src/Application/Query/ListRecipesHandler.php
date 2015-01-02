<?php

namespace CocktailRater\Application\Query;

use CocktailRater\Application\Handler;
use CocktailRater\Domain\Repository\RecipeRepository;
use CocktailRater\Domain\Recipe;

final class ListRecipesHandler implements Handler
{
    /** @var RecipeRepository */
    private $repository;

    // leanpub-start-insert
    public function __construct(
        ListRecipesQuery $query,
        RecipeRepository $repository
    ) {
        // leanpub-end-insert
        $this->repository = $repository;
    }

    // leanpub-start-insert
    /** @return ListRecipesResult */
    public function handle()
    {
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
