<?php

namespace CocktailRater\Domain;

// leanpub-start-insert
use Assert\Assertion;
use CocktailRater\Domain\Exception\OutOfBoundsException;
// leanpub-end-insert

final class Rating
{
    // leanpub-start-insert
    /** @var float */
    private $value;
    // leanpub-end-insert

    // leanpub-start-insert
    /**
     * @var float $value
     *
     * @throws OutOfBoundsException
     */
    // leanpub-end-insert
    public function __construct($value)
    {
        // leanpub-start-insert
        Assertion::numeric($value);

        $this->assertValueIsWithinRange($value);

        $this->value = (float) $value;
        // leanpub-end-insert
    }

    // leanpub-start-insert
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
    // leanpub-end-insert
}
