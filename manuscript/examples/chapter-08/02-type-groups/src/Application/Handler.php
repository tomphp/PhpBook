<?php

namespace CocktailRater\Application;

interface Handler
{
    // leanpub-start-insert
    /** @return mixed */
    public function handle(Query $query);
    // leanpub-end-insert
}
