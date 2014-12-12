<?php

namespace CocktailRater\Application;

use InvalidArgumentException;

class QueryHandler
{
    /**
     * @throws InvalidArgumentException If $query is not a query object.
     */
    public function handle($query)
    {
        throw new InvalidArgumentException();
    }
}
