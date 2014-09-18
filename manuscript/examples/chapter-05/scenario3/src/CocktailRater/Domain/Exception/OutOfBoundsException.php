<?php

namespace CocktailRater\Domain\Exception;

class OutOfBoundsException extends \OutOfBoundsException
{
    /**
     * @param number $number
     * @param number $min
     * @param number $max
     *
     * @return OutOfBoundsException
     */
    public static function numberIsOutOfBounds($number, $min, $max)
    {
        return new static(sprintf(
            'The number %d is out of bounds, expected a number between %d and %d.',
            $number,
            $min,
            $max
        ));
    }
}
