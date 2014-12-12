<?php

namespace CocktailRater\Domain\Exception;

trait ExceptionFactory
{
    /**
     * create
     *
     * @param mixed $message
     * @param mixed $params
     * @param int $code
     * @param mixed $previous
     *
     * @return self
     */
    protected static function create(
        $message,
        array $params = [],
        $code = 0,
        $previous = null
    ) {
        return new static(vsprintf($message, $params), $code, $previous);
    }
}
