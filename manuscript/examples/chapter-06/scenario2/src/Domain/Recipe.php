<?php

namespace CocktailRater\Domain;

final class Recipe
{
    // leanpub-start-insert
    /** @var CocktailName */
    private $name;

    /** @var Rating */
    private $rating;

    /** @var User */
    private $user;
    // leanpub-end-insert

    /** @param string $name */
    public function __construct(CocktailName $name, Rating $rating, User $user)
    {
        // leanpub-start-insert
        $this->name   = $name;
        $this->rating = $rating;
        $this->user   = $user;
        // leanpub-end-insert
    }

    // leanpub-start-insert
    /** @return CocktailName */
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
