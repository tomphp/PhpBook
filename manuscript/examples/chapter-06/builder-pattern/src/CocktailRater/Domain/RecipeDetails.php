<?php

namespace CocktailRater\Domain;

// leanpub-start-insert
use Assert\Assertion;
// leanpub-end-insert

final class RecipeDetails
{
    /** @var CocktailName */
    private $name;

    /** @var UserDetails */
    private $user;

    /** @var Rating */
    private $rating;

    // leanpub-start-insert
    /** @var Method */
    private $method;

    /** @var MeasuredIngredient[] */
    private $measuredIngredients;
    // leanpub-end-insert

    public function __construct(
        CocktailName $name,
        UserDetails $user,
        // leanpub-start-insert
        Rating $rating,
        Method $method,
        array $measuredIngredients
        // leanpub-end-insert
    ) {
        Assertion::allIsInstanceOf(
            $measuredIngredients,
            MeasuredIngredient::class
        );

        $this->name                = $name;
        $this->user                = $user;
        $this->rating              = $rating;
        // leanpub-start-insert
        $this->method              = $method;
        $this->measuredIngredients = $measuredIngredients;
        // leanpub-end-insert
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

    // leanpub-start-insert
    /** @return string */
    public function getMethod()
    {
        return $this->method->getValue();
    }

    /** @return array */
    public function getMeasuredIngredients()
    {
        return array_map(
            function (MeasuredIngredient $ingredient) {
                return [
                    'name'   => $ingredient->getIngredient()->getName(),
                    'amount' => $ingredient->getAmount()->getValue(),
                    'unit'   => $ingredient->getAmount()
                                           ->getUnit()
                                           ->getValue()
                ];
            },
            $this->measuredIngredients
        );
    }
    // leanpub-end-insert
}
