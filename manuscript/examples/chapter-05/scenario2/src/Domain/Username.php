<?php

namespace CocktailRater\Domain;

// leanpub-start-insert
use Assert\Assertion;
// leanpub-end-insert

final class Username
{
    // leanpub-start-insert
    /** @var string */
    private $value;
    // leanpub-end-insert

    /** @param string $value */
    public function __construct($value)
    {
        // leanpub-start-insert
        Assertion::string($value);

        $this->value = $value;
        // leanpub-end-insert
    }

    // leanpub-start-insert
    /** @param */
    public function getValue()
    {
        return $this->value;
    }
    // leanpub-end-insert
}
