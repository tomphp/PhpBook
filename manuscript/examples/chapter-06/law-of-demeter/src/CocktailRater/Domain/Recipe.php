<?php

namespace CocktailRater\Domain;

use Assert\Assertion;

final class Recipe
{
    /** @var string */
    private $name;

    /** @var Rating */
    private $rating;

    /** @var User */
    private $user;

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
        $method
    ) {
        Assertion::string($name);
        Assertion::allIsInstanceOf(
            $measuredIngredients,
            MeasuredIngredient::class
        );
        Assertion::string($method);

        $this->name                = $name;
        $this->rating              = $rating;
        $this->user                = $user;
        $this->method              = $method;
        $this->measuredIngredients = $measuredIngredients;
    }

//   /** @return string */
//   public function getName()
//   {
//       return $this->name;
//   }
//
//   /** @return Rating */
//   public function getRating()
//   {
//       return $this->rating;
//   }
//
//   /** @return User */
//   public function getUser()
//   {
//       return $this->user;
//   }
//
//   /** @return string */
//   public function getMethod()
//   {
//       return $this->method;
//   }
//
//   /** @return MeasuredIngredient[] */
//   public function getMeasuredIngredients()
//   {
//       return $this->measuredIngredients;
//   }

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
            $this->rating->getValue(),
            $this->method,
            array_map(
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
            )
        );
    }
    // leanpub-end-insert
}
