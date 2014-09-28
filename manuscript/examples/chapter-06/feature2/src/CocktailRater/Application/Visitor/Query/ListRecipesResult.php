<?php

namespace CocktailRater\Application\Visitor\Query;

interface ListRecipesResult
{
    /** @return array */
    public function getRecipes();
}
