<?php

namespace spec\CocktailRater\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Domain\Unit;

class IngredientAmountSpec extends ObjectBehavior
{
    function it_constructs_from_values()
    {
        $this->beConstructedThrough('fromValues', [10, 'ml']);

        $this->getValue()->shouldReturn(10.0);
        $this->getUnit()->shouldBeLike(new Unit('ml'));
    }
}
