<?php

namespace CocktailRater\Application\Visitor\Query;

use CocktailRater\Domain\Repository\RecipeRepository;

final class ListRecipesHandler
{
    // leanpub-start-insert
    /** @var RecipeRepository */
    private $repository;
    // leanpub-end-insert

    public function __construct(RecipeRepository $repository)
    {
        // leanpub-start-insert
        $this->repository = $repository;
        // leanpub-end-insert
    }

    /** @return ListRecipesResult */
    public function handle(ListRecipesQuery $query)
    {
        // leanpub-start-insert
        $result = new ListRecipesResult();

        foreach ($this->repository->findAll() as $recipe) {
            $result->add(
                $recipe->getName(),
                $recipe->getRating()->getValue(),
                $recipe->getUser()->getUsername()->getValue()
            );
        }

        return $result;
        // leanpub-end-insert
    }
}
