<?php

namespace CocktailRater\Domain;

final class RecipeDetails
{
    /** @var CocktailName */
    private $name;

    /** @var UserDetails */
    private $user;

    /** @var Rating */
    private $rating;

    public function __construct(
        CocktailName $name,
        UserDetails $user,
        Rating $rating
    ) {
        $this->name   = $name;
        $this->user   = $user;
        $this->rating = $rating;
    }

    /** @return string */
    public function getName()
    {
        return $this->name->getValue();
    }

    /** @return string */
    public function getUsername()
    {
        return $this->user->getUsername();
    }

    /** @return float */
    public function getRating()
    {
        return $this->rating->getValue();
    }
}
