<?php

namespace CocktailRater\Domain;

use Assert\Assertion;

final class Username
{
    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value)
    {
        Assertion::string($value);

        $this->value = $value;
    }

    /** @param */
    public function getValue()
    {
        return $this->value;
    }
}
