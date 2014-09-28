<?php

namespace CocktailRater\Domain;

final class RecipeDetails
{
    /** @var string */
    private $name;

    /** @var UserDetails */
    private $user;

    /** @var float */
    private $rating;

    /** @var string */
    private $method;

    /** @var array */
    private $ingredients;

    /**
     * @param string $name
     * @param float  $rating
     * @param string $method
     * @param array  $ingredients
     */
    public function __construct(
        $name,
        UserDetails $user,
        $rating,
        $method,
        array $ingredients
    ) {
        $this->name        = $name;
        $this->user        = $user;
        $this->rating      = $rating;
        $this->method      = $method;
        $this->ingredients = $ingredients;
    }

    /** @return string */
    public function getName()
    {
        return $this->name;
    }

    /** @return string */
    public function getUsername()
    {
        return $this->user->getUsername();
    }

    /** @return float */
    public function getRating()
    {
        return $this->rating;
    }

    /** @return string */
    public function getMethod()
    {
        return $this->method;
    }

    /** @return array */
    public function getMeasuredIngredients()
    {
        return $this->ingredients;
    }
}
