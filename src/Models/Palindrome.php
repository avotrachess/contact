<?php

namespace App\Models;

/**
 * Class PAlindrome
 */
class Palindrome
{
    /** @var string $name */
    protected $name;

    /**
     * Palindrome constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Vérifier si palindrome
     * 
     * @return bool
     */
    public function isValid(): bool
    {
        if (empty($this->name)) {
            return false;
        }

        return strrev($this->name) === $this->name;
    }
}