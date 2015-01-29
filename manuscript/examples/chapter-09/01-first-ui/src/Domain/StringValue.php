<?php

namespace CocktailRater\Domain;

use Assert\Assertion;

trait StringValue
{
    use SingleValue {
        SingleValue::__construct as private initSingleValue;
    }

    /** @param string $value */
    public function __construct($value)
    {
        Assertion::string($value);

        $this->initSingleValue($value);
    }
}
