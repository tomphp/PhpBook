<?php

namespace spec\CocktailRater\Domain;

use CocktailRater\Domain\Exception\OutOfBoundsException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RatingSpec extends ObjectBehavior
{
    function it_store_rating_value_as_a_float()
    {
        $this->beConstructedWith(3);

        $this->getValue()->shouldReturn(3.0);
    }

    function it_does_not_accept_ratings_below_1()
    {
        $this->shouldThrow(OutOfBoundsException::numberIsOutOfBounds(0.9, 1, 5))
             ->during('__construct', [0.9]);
    }

    function it_does_not_accept_ratings_above_5()
    {
        $this->shouldThrow(OutOfBoundsException::numberIsOutOfBounds(5.1, 1, 5))
             ->during('__construct', [5.1]);
    }
}
