<?php

namespace spec\CocktailRater\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UsernameSpec extends ObjectBehavior
{
    function it_stores_the_name_as_a_string()
    {
        $this->beConstructedWith(123);

        $this->getValue()->shouldReturn('123');
    }
}
