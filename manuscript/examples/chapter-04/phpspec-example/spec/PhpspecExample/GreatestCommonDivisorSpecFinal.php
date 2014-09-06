<?php

namespace spec\PhpspecExample;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GreatestCommonDivisorSpec extends ObjectBehavior
{
    function it_returns_the_number_if_both_values_are_that_number()
    {
        $this->findGreatestDivisor(5, 5)->shouldReturn(5);
    }

    function it_returns_the_first_number_if_it_is_a_divisor_of_the_second()
    {
        $this->findGreatestDivisor(3, 9)->shouldReturn(3);
    }

    function it_returns_the_second_number_if_it_is_a_divisor_of_the_first()
    {
        $this->findGreatestDivisor(9, 3)->shouldReturn(3);
    }

    function it_returns_1_if_there_is_no_greater_divisor()
    {
        $this->findGreatestDivisor(3, 5)->shouldReturn(1);
    }

    function it_returns_a_divisor_of_both_numbers()
    {
        $this->findGreatestDivisor(6, 9)->shouldReturn(3);
    }
}
