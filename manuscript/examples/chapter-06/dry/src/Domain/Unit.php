<?php

namespace CocktailRater\Domain;

use Assert\Assertion;

final class Unit
{
    // leanpub-start-input
    use StringValue {
        StringValue::__construct as private initStringValue;
    }
    // leanpub-end-input

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

        // leanpub-start-input
        $this->initStringValue($value);
        // leanpub-end-input
    }
}
