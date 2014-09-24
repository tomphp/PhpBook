<?php

namespace CocktailRater\Domain\Repository\Exception;

// leanpub-start-insert
use CocktailRater\Domain\Exception\ExceptionFactory;
// leanpub-end-insert
use CocktailRater\Domain\Identity;

class NoSuchEntityException extends \RuntimeException
{
    // leanpub-start-insert
    use ExceptionFactory;
    // leanpub-end-insert

    /**
     * @param string $entityName
     *
     * @return self
     */
    public static function invalidId($entityName, Identity $id)
    {
        // leanpub-start-insert
        return self::create(
            'A %s with the id "%s" does not exist.',
            [$entityName, $id]
        );
        // leanpub-end-insert
    }
}
