<?php

namespace CocktailRater\Domain;

use Assert\Assertion;

final class Ingredient
{
    /** @var string */
    private $name;

    /**
     * @param string $name
     *
     * @return Ingredient
     */
    public static function fromValues($name)
    {
        return new self(new IngredientName($name));
    }

    public function __construct(IngredientName $name)
    {
        $this->name = $name;
    }

    /** @return string */
    public function getName()
    {
        return $this->name->getValue();
    }
}
