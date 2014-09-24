<?php

namespace CocktailRater\Application\Exception;

// leanpub-start-insert
use CocktailRater\Domain\Exception\ExceptionFactory;
// leanpub-end-insert
use Exception;

class InvalidIdException extends ApplicationException
{
    // leanpub-start-insert
    use ExceptionFactory;
    // leanpub-end-insert

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
        // leanpub-start-insert
        return self::create(
            'A %s entity with id "%s" does not exist.',
            [$entityName, $id],
            0,
            $previous
        );
        // leanpub-end-insert
    }
}
