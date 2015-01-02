<?php

namespace spec\CocktailRater\Domain;

use CocktailRater\Domain\Amount;
use CocktailRater\Domain\Ingredient;
use CocktailRater\Domain\Unit;
use PhpSpec\ObjectBehavior;

class MeasuredIngredientSpec extends ObjectBehavior
{
    function it_provides_details()
    {
        $this->beConstructedWith(
            Ingredient::fromValues('test name'),
            Amount::fromValues(10, Unit::ML)
        );

        $this->shouldHaveType('CocktailRater\Domain\MeasuredIngredientDetails');

        $this->getName()->shouldReturn('test name');
        $this->getAmount()->shouldReturn(10);
        $this->getUnit()->shouldReturn(Unit::ML);
    }
}
