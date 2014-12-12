<?php

namespace CocktailRater\Application\Query;

use CocktailRater\Domain\Repository\RecipeRepository;
use CocktailRater\Domain\Recipe;

final class ListRecipesHandler
{
    /** @var RecipeRepository */
    private $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    /** @return ListRecipesResult */
    public function handle(ListRecipesQuery $query)
    {
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
