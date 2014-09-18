<?php

namespace CocktailRater\Domain;

// leanpub-start-insert
use Assert\Assertion;
// leanpub-end-insert

final class Recipe
{
    // leanpub-start-insert
    /** @var string */
    private $name;

    /** @var Rating */
    private $rating;

    /** @var User */
    private $user;
    // leanpub-end-insert

    /** @param string $name */
    public function __construct($name, Rating $rating, User $user)
    {
        // leanpub-start-insert
        Assertion::string($name);

        $this->name   = $name;
        $this->rating = $rating;
        $this->user   = $user;
        // leanpub-end-insert
    }

    // leanpub-start-insert
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
    // leanpub-end-insert
}
