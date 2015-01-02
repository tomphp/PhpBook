<?php

namespace CocktailRater\Application\Exception;

use CocktailRater\Domain\Exception\ExceptionFactory;

class NoMatchingHandlerException extends ApplicationException
{
    use ExceptionFactory;

    /**
     * @param string $queryName
     * @param string $handerName
     *
     * @return self
     */
    public static function notFound($queryName, $handlerName)
    {
        return self::create(
            'Handler "%s" does not exist for query "%s".',
            [$handlerName, $queryName]
        );
    }
}
