<?php

namespace spec\PhpspecExample;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GreatestCommonDivisorFinderSpec extends ObjectBehavior
{
    function it_returns_the_number_if_both_values_are_that_number()
    {
        $this->findGreatestDivisor(5, 5)->shouldReturn(5);
    }
}
