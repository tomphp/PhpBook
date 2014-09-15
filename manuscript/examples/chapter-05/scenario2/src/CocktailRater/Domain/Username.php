<?php

namespace CocktailRater\Domain;

final class Username
{
    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value)
    {
        $this->value = (string) $value;
    }

    /** @param */
    public function getValue()
    {
        return $this->value;
    }
}
