<?php

namespace CocktailRater\Application\Exception;

use CocktailRater\Domain\Exception\ExceptionFactory;

class NotAHandlerException extends ApplicationException
{
    use ExceptionFactory;

    /**
     * @param string $handerName
     *
     * @return self
     */
    public static function missingHandleMethod($handlerName)
    {
        return self::create(
            'Handler "%s" doesn\'t have a method called "handle".',
            [$handlerName]
        );
    }
}
