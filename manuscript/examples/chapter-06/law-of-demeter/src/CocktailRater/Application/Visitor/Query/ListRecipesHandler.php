<?php

namespace CocktailRater\Application\Visitor\Query;

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
        $result = new ListRecipesResult();

        foreach ($this->getAllRecipesSortedByRating() as $recipe) {
            // leanpub-start-insert
            $details = $recipe->getDetails();
            // leanpub-end-insert

            $result->addRecipe(
                $details->getName(),
                $details->getRating(),
                $details->getUsername()
            );
        }

        return $result;
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
