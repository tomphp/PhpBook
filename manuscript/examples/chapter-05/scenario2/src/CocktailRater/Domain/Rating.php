<?php

namespace CocktailRater\Domain;

use CocktailRater\Domain\Exception\OutOfBoundsException;

final class Rating
{
    /** @var float */
    private $value;

    /**
     * @var float $value
     *
     * @throws OutOfBoundsException
     */
    public function __construct($value)
    {
        $this->assertValueIsWithinRange($value);

        $this->value = (float) $value;
    }

    /** @return float */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @var float $value
     *
     * @throws OutOfBoundsException
     */
    private function assertValueIsWithinRange($value)
    {
        if ($value < 1 || $value > 5) {
            throw OutOfBoundsException::numberIsOutOfBounds($value, 1, 5);
        }
    }
}
