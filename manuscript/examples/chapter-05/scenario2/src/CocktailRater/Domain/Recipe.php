<?php

namespace CocktailRater\Domain;

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
        $this->name   = (string) $name;
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
}
