<?php

namespace CocktailRater\Application;

interface Handler
{
    // leanpub-start-insert
    /**
     * @return Result
     */
    public function handle(Query $query);
    // leanpub-end-insert
}
