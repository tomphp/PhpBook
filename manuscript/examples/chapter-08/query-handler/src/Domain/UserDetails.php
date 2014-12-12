<?php

namespace CocktailRater\Domain;

final class UserDetails
{
    /** @var Username */
    private $username;

    public function __construct(Username $username)
    {
        $this->username = $username;
    }

    /** @return Username */
    public function getUsername()
    {
        return $this->username->getValue();
    }
}
