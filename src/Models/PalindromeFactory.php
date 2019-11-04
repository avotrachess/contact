<?php

namespace App\Models;

use App\Models\Palindrome;

/**
 * Classe PalindromeFactory
 */
class PalindromeFactory
{
    /**
     * Creer un objet palindrome
     * 
     * @param string $name
     * 
     * @return Palindrome
     */
    public static function create(string $name): Palindrome
    {
        return new Palindrome($name);
    }
}