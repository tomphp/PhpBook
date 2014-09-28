<?php

namespace CocktailRater\Domain;

use Assert\Assertion;
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
        Assertion::numeric($value);

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

    // leanpub-start-insert
    /** @return bool */
    public function isHigherThan(Rating $other)
    {
        return $this->value > $other->value;
    }
    // leanpub-end-insert
}
