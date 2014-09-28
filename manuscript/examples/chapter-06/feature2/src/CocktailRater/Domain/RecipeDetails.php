<?php

namespace CocktailRater\Domain;

use Assert\Assertion;

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

    /** @var MeasuredIngredientDetails[] */
    private $measuredIngredients;
    // leanpub-end-insert

    /** @param MeasuredIngredientDetails[] $measuredIngredients */
    public function __construct(
        CocktailName $name,
        UserDetails $user,
        Rating $rating,
        Method $method,
        array $measuredIngredients
    ) {
        // leanpub-end-insert
        Assertion::allIsInstanceOf(
            $measuredIngredients,
            MeasuredIngredientDetails::class
        );
        // leanpub-end-insert

        $this->name                = $name;
        $this->user                = $user;
        $this->rating              = $rating;
        $this->method              = $method;
        $this->measuredIngredients = $measuredIngredients;
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

    /** @return string */
    public function getMethod()
    {
        return $this->method->getValue();
    }

    /** @return array */
    public function getMeasuredIngredients()
    {
        return array_map(
            function (MeasuredIngredientDetails $ingredient) {
                return [
                    // leanpub-start-insert
                    'name'   => $ingredient->getName(),
                    'amount' => $ingredient->getAmount(),
                    'unit'   => $ingredient->getUnit()
                    // leanpub-end-insert
                ];
            },
            $this->measuredIngredients
        );
    }
}
