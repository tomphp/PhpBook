<?php

namespace CocktailRater\Domain;

trait SingleValue
{
    /** @var mixed */
    protected $value;

    /** @param mixed $value */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /** @return mixed */
    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
