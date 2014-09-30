<?php

namespace CocktailRater\Domain;

use Assert\Assertion;

final class RecipeId
{
    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value)
    {
        Assertion::string($value);

        $this->value = $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }
}
