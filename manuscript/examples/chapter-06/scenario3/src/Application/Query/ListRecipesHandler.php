<?php

namespace CocktailRater\Application\Query;

use CocktailRater\Domain\Repository\RecipeRepository;
// leanpub-start-insert
use CocktailRater\Domain\Recipe;
// leanpub-end-insert

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
        $result = new ListRecipesResult();

        // leanpub-start-insert
        foreach ($this->getAllRecipesSortedByRating() as $recipe) {
        // leanpub-end-insert
            $result->addRecipe(
                $recipe->getName()->getValue(),
                $recipe->getRating()->getValue(),
                $recipe->getUser()->getUsername()->getValue()
            );
        }

        return $result;
    }

    // leanpub-start-insert
    private function getAllRecipesSortedByRating()
    {
        $recipes = $this->repository->findAll();

        usort($recipes, function (Recipe $a, Recipe $b) {
            return $a->isHigherRatedThan($b) ? -1 : 1;
        });

        return $recipes;
    }
    // leanpub-end-insert
}
