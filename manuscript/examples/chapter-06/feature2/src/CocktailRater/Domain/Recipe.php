<?php

namespace CocktailRater\Domain;

use Assert\Assertion;
use CocktailRater\Domain\Recipe;

final class Recipe
{
    /** @var Identity */
    private $id;

    /** @var string */
    private $name;

    /** @var Rating */
    private $rating;

    /** @var User */
    private $user;

    /**
     * @param string               $name
     * @param MeasuredIngredient[] $measuredIngredients
     * @param string               $method
     */
    public function __construct(
        $name,
        Rating $rating,
        User $user,
        array $measuredIngredients,
        $method,
        Identity $id = null
    ) {
        Assertion::string($name);
        Assertion::allIsInstanceOf(
            $measuredIngredients,
            MeasuredIngredient::class
        );
        //Assertion::string($method);

        $this->id                  = $id;
        $this->name                = $name;
        $this->rating              = $rating;
        $this->user                = $user;
        $this->method              = $method;
        $this->measuredIngredients = $measuredIngredients;
    }

    /** @return Identity */
    public function getId()
    {
        return $this->id;
    }

    /** @return string */
    public function getName()
    {
        return $this->name;
    }

    /** @return Rating */
    public function getRating()
    {
        return $this->rating;
    }

    /** @return User */
    public function getUser()
    {
        return $this->user;
    }

    /** @return string */
    public function getMethod()
    {
        return $this->method;
    }

    /** @return MeasuredIngredient[] */
    public function getMeasuredIngredients()
    {
        return $this->measuredIngredients;
    }

    public function isHigherRatedThan(Recipe $other)
    {
        return $this->rating->isHigherThan($other->rating);
    }
}
