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

    // leanpub-start-insert
    /** @return UserDetails */
    public function getDetails()
    {
        return new UserDetails($this->username);
    }
    // leanpub-end-insert
}
