<?php

namespace CocktailRater\Domain;

// leanpub-start-insert
use Assert\Assertion;
// leanpub-end-insert

final class CocktailName
{
    // leanpub-start-insert
    /** @var string */
    private $value;
    // leanpub-start-insert

    /** @param string $value */
    public function __construct($value)
    {
        // leanpub-start-insert
        Assertion::string($value);

        $this->value = $value;
        // leanpub-start-insert
    }

    // leanpub-start-insert
    /** @return string */
    public function getValue()
    {
        return $this->value;
    }
    // leanpub-start-insert
}
