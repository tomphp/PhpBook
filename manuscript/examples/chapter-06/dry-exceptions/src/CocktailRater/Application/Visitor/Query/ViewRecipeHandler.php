<?php

namespace CocktailRater\Application\Visitor\Query;

use CocktailRater\Application\Exception\InvalidIdException;
use CocktailRater\Domain\Identity;
use CocktailRater\Domain\MeasuredIngredient;
use CocktailRater\Domain\Recipe;
use CocktailRater\Domain\Repository\Exception\NoSuchEntityException;
use CocktailRater\Domain\Repository\RecipeRepository;

final class ViewRecipeHandler
{
    /** @var RecipeRepository */
    private $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ViewRecipeResult
     *
     * @throws InvalidIdException
     */
    public function handle(ViewRecipeQuery $query)
    {
        $recipe = $this->findRecipe($query);

        return new ViewRecipeResult(
            $recipe->getName(),
            $recipe->getUser()->getUsername()->getValue(),
            $recipe->getRating()->getValue(),
            $recipe->getMethod(),
            array_map(
                function (MeasuredIngredient $ingredient) {
                    return [
                        'name'   => $ingredient->getIngredient()->getName(),
                        'amount' => $ingredient->getAmount()->getValue(),
                        'unit'   => $ingredient->getAmount()
                                               ->getUnit()
                                               ->getValue()
                    ];
                },
                $recipe->getMeasuredIngredients()
            )
        );
    }

    /**
     * @return Recipe
     *
     * @throws InvalidIdException
     */
    private function findRecipe($query)
    {
        try {
            return $this->repository->findById(new Identity($query->getId()));
        } catch (NoSuchEntityException $e) {
            throw InvalidIdException::invalidEntityId(
                'Recipe',
                $query->getId(),
                $e
            );
        }
    }
}
