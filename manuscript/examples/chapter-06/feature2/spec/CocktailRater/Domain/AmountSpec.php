<?php

namespace spec\CocktailRater\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Domain\Unit;

class AmountSpec extends ObjectBehavior
{
    function it_constructs_from_values()
    {
        $this->beConstructedThrough('fromValues', [10, Unit::ML]);

        $this->getValue()->shouldReturn(10);
        $this->getUnit()->shouldBeLike(new Unit(Unit::ML));
    }
}
