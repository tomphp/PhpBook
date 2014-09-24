<?php

namespace CocktailRater\Domain\Exception;

class OutOfBoundsException extends \OutOfBoundsException
{
    // leanpub-start-insert
    use ExceptionFactory;
    // leanpub-end-insert

    /**
     * @param number $number
     * @param number $min
     * @param number $max
     *
     * @return OutOfBoundsException
     */
    public static function numberIsOutOfBounds($number, $min, $max)
    {
        // leanpub-start-insert
        return self::create(
            'The number %d is out of bounds, expected a number between %d and %d.',
            [$number, $min, $max]
        );
        // leanpub-end-insert
    }
}
