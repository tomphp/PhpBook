<?php

namespace CocktailRater\Domain\Exception;

class OutOfBoundsException extends \OutOfBoundsException
{
    use ExceptionFactory;

    /**
     * @param number $number
     * @param number $min
     * @param number $max
     *
     * @return OutOfBoundsException
     */
    public static function numberIsOutOfBounds($number, $min, $max)
    {
        return self::create(
            'The number %d is out of bounds, expected a number between %d and %d.',
            [$number, $min, $max]
        );
    }
}
