<?php

namespace CocktailRater\Application\Exception;

use CocktailRater\Domain\Exception\ExceptionFactory;
use Exception;

class InvalidIdException extends ApplicationException
{
    use ExceptionFactory;

    /**
     * @param string $entityName
     * @param string $id
     *
     * @return self
     */
    public static function invalidEntityId(
        $entityName,
        $id,
        Exception $previous
    ) {
        return self::create(
            'A %s entity with id "%s" does not exist.',
            [$entityName, $id],
            0,
            $previous
        );
    }
}
