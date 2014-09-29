<?php

namespace CocktailRater\Application\Visitor\Query;

use Assert\Assertion;
use CocktailRater\Domain\RecipeDetails;

final class ListRecipesResultData implements ListRecipesResult
{
    /** @var RecipeDetails[] */
    private $recipes = [];

    public function __construct(array $recipes)
    {
        Assertion::allIsInstanceOf($recipes, RecipeDetails::class);

        $this->recipes = $recipes;
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
