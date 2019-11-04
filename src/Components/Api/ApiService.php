<?php

namespace App\Components\Api;

use App\Models\PalindromeFactory;
use Psr\Log\LoggerInterface;

/**
 * Classe ApiService
 */
class ApiService
{
    /** @var PalindromeFactory $factory */
    protected $factory;

    /** @var LoggerInterface $logger */
    protected $logger;

    /**
     * Contructeur
     * 
     * @param PalindromeFactory $factory
     */
    public function __construct(PalindromeFactory $factory, LoggerInterface $logger) {
        $this->factory = $factory;
        $this->logger = $logger;
    }

    /**
     * Palindrome
     * 
     * @param string $name
     * 
     * @return bool
     */
    public function isPalindrome(string $name): bool
    {
        $this->logger->info('Service isPalindrome');

        $palindrome = $this->factory::create($name);

        return $palindrome->isValid();
    }

    /**
     * Vérification du format de l'email
     * @param string $email
     * 
     * @return bool
     */
    public function isEmail(string $email): bool
    {
        $this->logger->info('Service isEmail');

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } 

        return false;
    }
}