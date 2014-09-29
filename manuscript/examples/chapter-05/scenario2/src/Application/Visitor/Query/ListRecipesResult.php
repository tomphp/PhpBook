<?php

namespace CocktailRater\Application\Visitor\Query;

final class ListRecipesResult
{
    // leanpub-start-insert
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
    // leanpub-end-insert

    /** @return array */
    public function getRecipes()
    {
        // leanpub-start-insert
        return $this->recipes;
        // leanpub-end-insert
    }
}
