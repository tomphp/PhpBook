<?php

namespace spec\CocktailRater\Application;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QueryHandlerSpec extends ObjectBehavior
{
    function it_throws_if_class_is_not_a_query()
    {
        $this->shouldThrow(new \InvalidArgumentException())
             ->duringHandle(new \stdClass());
    }
}

class TestQuery
{
}

class TestQueryHandler
{
}
