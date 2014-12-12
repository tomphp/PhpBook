<?php

namespace CocktailRater\Domain;

use Assert\Assertion;

final class Unit
{
    use StringValue {
        StringValue::__construct as private initStringValue;
    }

    const ML    = 'ml';
    const FL_OZ = 'fl oz';
    const TSP   = 'tsp';
    const COUNT = '';

    /** @param string $value */
    public function __construct($value)
    {
        Assertion::inArray(
            $value,
            [self::ML, self::FL_OZ, self::TSP, self::COUNT]
        );

        $this->initStringValue($value);
    }
}
