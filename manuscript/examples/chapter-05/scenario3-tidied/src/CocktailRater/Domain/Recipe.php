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
    }

    /** @return bool */
    public function isHigherRatedThan(Recipe $other)
    {
        return $this->rating->isHigherThan($other->rating);
    }

    // leanpub-start-insert
    /** @return RecipeDetails */
    public function getDetails()
    {
        return new RecipeDetails(
            $this->name,
            $this->user->getDetails(),
            $this->rating
        );
    }
    // leanpub-end-insert
}
