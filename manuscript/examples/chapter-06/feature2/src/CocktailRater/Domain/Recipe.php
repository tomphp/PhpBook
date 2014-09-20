<?php

namespace CocktailRater\Domain;

use Assert\Assertion;
use CocktailRater\Domain\Recipe;

final class Recipe
{
    /** @var string */
    private $name;

    /** @var Rating */
    private $rating;

    /** @var User */
    private $user;

    /** @param string $name */
    public function __construct($name, Rating $rating, User $user)
    {
        Assertion::string($name);

        $this->name   = $name;
        $this->rating = $rating;
        $this->user   = $user;
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

    public function isHigherRatedThan(Recipe $other)
    {
        return $this->rating->isHigherThan($other->rating);
    }
}
