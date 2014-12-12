<?php

namespace spec\CocktailRater\Domain;

use CocktailRater\Domain\CocktailName;
use CocktailRater\Domain\Rating;
use CocktailRater\Domain\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RecipeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(
            new CocktailName('test name'),
            new Rating(5),
            User::fromValues('test user')
        );

        $this->shouldHaveType('CocktailRater\Domain\Recipe');
    }
}
