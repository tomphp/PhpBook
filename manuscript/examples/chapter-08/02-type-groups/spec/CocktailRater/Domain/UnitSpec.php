<?php

namespace spec\CocktailRater\Domain;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use CocktailRater\Domain\Unit;

class UnitSpec extends ObjectBehavior
{
    function it_rejects_invalid_values()
    {
        $this->shouldThrow(new InvalidArgumentException(
            'Value "bad value" is not an element of the valid values: ml, fl oz, tsp, ',
            22
        ))->during('__construct', ['bad value']);
    }

    function it_accepts_accepts_valid_values()
    {
        new Unit(Unit::ML);
        new Unit(Unit::FL_OZ);
        new Unit(Unit::TSP);
        new Unit(Unit::COUNT);
    }
}
