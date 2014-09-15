<?php

namespace spec\CocktailRater\Application\Visitor\Query;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ListRecipesResultSpec extends ObjectBehavior
{
    function it_starts_with_an_empty_list_of_recipes()
    {
        $this->getRecipes()->shouldReturn([]);
    }

    function it_can_add_recipes_details()
    {
        $this->add('recipe 1', 3.0, 'user a');
        $this->add('recipe 2', 5.0, 'user b');

        $this->getRecipes()->shouldReturn([
            [
                'name'   => 'recipe 1',
                'rating' => 3.0,
                'user'   => 'user a'
            ],
            [
                'name'   => 'recipe 2',
                'rating' => 5.0,
                'user'   => 'user b'
            ]
        ]);
    }
}
