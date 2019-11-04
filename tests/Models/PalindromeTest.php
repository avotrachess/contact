<?php

namespace App\Tests\Models;

use App\Models\Palindrome;
use PHPUnit\Framework\TestCase;

/**
 * Class PalindromeTest
 */
class PalindromeTest extends TestCase
{
    /**
     * Fonction test est valide 
     */
    public function testIsValid()
    {
        $palindrome = new Palindrome('radar');

        $result = $palindrome->isValid();

        $this->assertTrue($result);
    }

    /**
     * Fonction test n'est pas valide 
     */
    public function testIsNotValid()
    {
        $palindrome = new Palindrome('test');

        $result = $palindrome->isValid();

        $this->assertFalse($result);
    }
}