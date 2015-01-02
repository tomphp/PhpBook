<?php

namespace CocktailRater\Application;

interface Handler
{
    /** @return mixed */
    public function handle($query);
}
