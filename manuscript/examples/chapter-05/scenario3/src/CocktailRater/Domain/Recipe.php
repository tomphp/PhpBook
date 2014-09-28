<?php

namespace CocktailRater\Domain;

final class Recipe
{
    /** @var CocktailName */
    private $name;

    /** @var Rating */
    private $rating;

    /** @var User */
    private $user;

    /** @param string $name */
    public function __construct(CocktailName $name, Rating $rating, User $user)
    {
        $this->name   = $name;
        $this->rating = $rating;
        $this->user   = $user;
        // leanpub-end-insert
    }

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

    // leanpub-start-insert
    /** @return bool */
    public function isHigherRatedThan(Recipe $other)
    {
        return $this->rating->isHigherThan($other->rating);
    }
    // leanpub-end-insert
}
