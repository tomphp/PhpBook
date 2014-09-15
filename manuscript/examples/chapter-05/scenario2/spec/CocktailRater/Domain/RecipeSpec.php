<?php

namespace spec\CocktailRater\Domain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use CocktailRater\Domain\User;
use CocktailRater\Domain\Rating;

class RecipeSpec extends ObjectBehavior
{
    function it_stores_name_as_a_string()
    {
        $this->beConstructedWith(123, new Rating(1), User::fromValues('tom'));

        $this->getName()->shouldReturn('123');
    }
}
