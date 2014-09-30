<?php

namespace spec\CocktailRater\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Domain\Username;

class UserSpec extends ObjectBehavior
{
    const TEST_USER = 'test_user';

    function let()
    {
        $this->beConstructedThrough('fromValues', [self::TEST_USER]);
    }

    function it_returns_UserDetails()
    {
        $details = $this->getDetails();

        $details->shouldBeAnInstanceOf('CocktailRater\Domain\UserDetails');

        $details->getUsername()->shouldReturn('test_user');
    }
}
