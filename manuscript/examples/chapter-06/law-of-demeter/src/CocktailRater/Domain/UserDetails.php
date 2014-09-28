<?php

namespace CocktailRater\Domain;

final class UserDetails
{
    /** @var string */
    private $username;

    /** @param string $username */
    public function __construct($username)
    {
        $this->username = $username;
    }

    /** @return string */
    public function getUsername()
    {
        return $this->username;
    }
}
