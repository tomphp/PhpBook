<?php

namespace spec\CocktailRater\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UsernameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('test username');

        $this->shouldHaveType('CocktailRater\Domain\Username');
    }
}
