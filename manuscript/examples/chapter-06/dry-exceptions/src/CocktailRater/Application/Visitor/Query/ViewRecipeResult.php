<?php

namespace CocktailRater\Application\Visitor\Query;

final class ViewRecipeResult
{
    /** @var string */
    private $name;

    /** @var string */
    private $username;

    /** @var float */
    private $rating;

    /** @var string */
    private $method;

    /** @var array */
    private $measuredIngredients;

    /**
     * @param string $name
     * @param string $username
     * @param float  $rating
     * @param string $method
     */
    public function __construct(
        $name,
        $username,
        $rating,
        $method,
        array $measuredIngredients
    ) {
        $this->name                = $name;
        $this->username            = $username;
        $this->rating              = $rating;
        $this->method              = $method;
        $this->measuredIngredients = $measuredIngredients;
    }

    /** @return string */
    public function getName()
    {
        return $this->name;
    }

    /** @return string */
    public function getUsername()
    {
        return $this->username;
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
        return $this->measuredIngredients;
    }
}
