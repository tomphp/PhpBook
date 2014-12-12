<?php

namespace CocktailRater\Application\Query;

final class ListRecipesResult
{
    /** @var array */
    private $recipes = [];

    /**
     * @param string $name
     * @param float  $rating
     * @param string $username
     */
    public function addRecipe($name, $rating, $username)
    {
        $this->recipes[] = [
            'name'     => $name,
            'rating'   => $rating,
            'user' => $username
        ];
    }

    /** @return array */
    public function getRecipes()
    {
        return $this->recipes;
    }
}
