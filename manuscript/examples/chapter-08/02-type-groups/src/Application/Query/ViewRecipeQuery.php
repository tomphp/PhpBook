<?php

namespace CocktailRater\Application\Query;

use Assert\Assertion;
// leanpub-start-insert
use CocktailRater\Application\Query;

final class ViewRecipeQuery extends Query
// leanpub-end-insert
{
    /** @var string */
    private $id;

    /** @param string $id */
    public function __construct($id)
    {
        Assertion::string($id);

        $this->id = $id;
    }

    /** @return string */
    public function getId()
    {
        return $this->id;
    }
}
