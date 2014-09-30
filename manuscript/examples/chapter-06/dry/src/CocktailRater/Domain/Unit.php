<?php

namespace CocktailRater\Domain;

use Assert\Assertion;

final class Unit
{
    const ML    = 'ml';
    const FL_OZ = 'fl oz';
    const TSP   = 'tsp';
    const COUNT = '';

    /** @var string */
    private $value;

    /** @param string $value */
    public function __construct($value)
    {
        Assertion::inArray(
            $value,
            [self::ML, self::FL_OZ, self::TSP, self::COUNT]
        );

        $this->value = $value;
    }

    /** @return string */
    public function getValue()
    {
        return $this->value;
    }
}
