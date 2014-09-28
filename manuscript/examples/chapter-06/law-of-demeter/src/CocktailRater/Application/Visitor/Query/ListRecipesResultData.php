<?php

namespace CocktailRater\Application\Visitor\Query;

use CocktailRater\Domain\RecipeDetails;

final class ListRecipesResultData implements ListRecipesResult
{
    /** @var RecipeDetails */
    private $recipes = [];

    public function addRecipe(RecipeDetails $recipe)
    {
        $this->recipes[] = $recipe;
    }

    /** @return array */
    public function getRecipes()
    {
        return array_map(
            function (RecipeDetails $recipe) {
                return [
                    'name'   => $recipe->getName(),
                    'rating' => $recipe->getRating(),
                    'user'   => $recipe->getUsername()
                ];
            },
            $this->recipes
        );
    }
}
