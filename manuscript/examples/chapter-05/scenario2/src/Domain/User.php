<?php

namespace CocktailRater\Domain;

final class User
{
    /** @var Username */
    private $username;

    /**
     * @param string $username
     *
     * @return User
     */
    public static function fromValues($username)
    {
        return new self(new Username($username));
    }

    /** @var string $username */
    public function __construct(Username $username)
    {
        $this->username = $username;
    }

    /** @return Username */
    public function getUsername()
    {
        return $this->username;
    }
}
