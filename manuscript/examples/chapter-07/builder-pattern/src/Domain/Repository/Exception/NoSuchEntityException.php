<?php

namespace CocktailRater\Domain\Repository\Exception;

use CocktailRater\Domain\RecipeId;

class NoSuchEntityException extends \RuntimeException
{
    /**
     * @param string $entityName
     *
     * @return self
     */
    public static function invalidId($entityName, RecipeId $id)
    {
        return new static(sprintf(
            'A %s with the id "%s" does not exist.',
            $entityName,
            $id
        ));
    }
}
