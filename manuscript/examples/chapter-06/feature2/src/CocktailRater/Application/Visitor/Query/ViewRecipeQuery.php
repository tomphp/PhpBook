<?php

namespace CocktailRater\Application\Visitor\Query;

final class ViewRecipeQuery
{
    /** @var string */
    private $id;

    /** @param string $id */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /** @return string */
    public function getId()
    {
        return $this->id;
    }
}
