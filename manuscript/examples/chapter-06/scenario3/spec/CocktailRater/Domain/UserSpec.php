<?php

namespace spec\CocktailRater\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Domain\Username;

class UserSpec extends ObjectBehavior
{
    function it_can_be_created_from_values()
    {
        $this->beConstructedThrough('fromValues', ['test_user']);

        $this->getUsername()->shouldBeLike(new Username('test_user'));
    }
}
