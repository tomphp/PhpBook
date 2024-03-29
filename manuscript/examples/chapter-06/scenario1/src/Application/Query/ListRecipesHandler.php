<?php

namespace CocktailRater\Application\Query;

use CocktailRater\Domain\Repository\RecipeRepository;

final class ListRecipesHandler
{
    public function __construct(RecipeRepository $repository)
    {
    }

    /** @return ListRecipesResult */
    public function handle(ListRecipesQuery $query)
    {
        return new ListRecipesResult();
    }
}
