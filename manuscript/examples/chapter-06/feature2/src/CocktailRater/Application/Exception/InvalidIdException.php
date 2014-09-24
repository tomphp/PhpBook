<?php

namespace CocktailRater\Application\Exception;

class InvalidIdException extends ApplicationException
{
    /**
     * @param string $entityName
     * @param string $id
     *
     * @return self
     */
    public static function invalidEntityId($entityName, $id)
    {
        return new static(sprintf(
            'A %s entity with id "%s" does not exist.',
            $entityName,
            $id
        ));
    }
}
