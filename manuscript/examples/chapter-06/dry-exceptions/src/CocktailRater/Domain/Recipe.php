<?php

namespace CocktailRater\Domain;

use Assert\Assertion;
use CocktailRater\Domain\Recipe;

final class Recipe
{
    // leanpub-start-insert
    /** @var Identity */
    private $id;
    // leanpub-end-insert

    /** @var string */
    private $name;

    /** @var Rating */
    private $rating;

    /** @var User */
    private $user;

    // leanpub-start-insert
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
    // leanpub-end-insert
        Assertion::string($name);
        // leanpub-start-insert
        Assertion::allIsInstanceOf(
            $measuredIngredients,
            MeasuredIngredient::class
        );
        Assertion::string($method);
        // leanpub-end-insert

        $this->name                = $name;
        $this->rating              = $rating;
        $this->user                = $user;
        // leanpub-start-insert
        $this->id                  = $id;
        $this->method              = $method;
        $this->measuredIngredients = $measuredIngredients;
        // leanpub-end-insert
    }

    // leanpub-start-insert
    /** @return Identity */
    public function getId()
    {
        return $this->id;
    }
    // leanpub-end-insert

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

    // leanpub-start-insert
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
    // leanpub-end-insert

    public function isHigherRatedThan(Recipe $other)
    {
        return $this->rating->isHigherThan($other->rating);
    }
}
