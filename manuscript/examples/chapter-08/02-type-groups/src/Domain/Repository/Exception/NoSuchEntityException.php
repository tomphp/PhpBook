<?php

namespace CocktailRater\Domain\Repository\Exception;

use CocktailRater\Domain\Exception\ExceptionFactory;
use CocktailRater\Domain\RecipeId;

class NoSuchEntityException extends \RuntimeException
{
    use ExceptionFactory;

    /**
     * @param string $entityName
     *
     * @return self
     */
    public static function invalidId($entityName, RecipeId $id)
    {
        return self::create(
            'A %s with the id "%s" does not exist.',
            [$entityName, $id]
        );
    }
}
