<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Components\Api\ApiService;

/**
 * Classe Api controlleur
 */
class Api extends AbstractController
{
    /** @var ApiService $apiService */
    protected $apiService;

    /**
     * Contructeur de Api
     */
    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Palindrome
     * 
     * @Route("/api/palindrome", methods={"POST"})
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function palindrome(Request $request): JsonResponse
    {
        $name = $request->request->get('name');

        if (!$name) {
            return new JsonResponse([
                "response" => false,
                "message"  => "Pas de nom renseigné",
            ]);
        }

        if ($this->apiService->isPalindrome($name)) {
            return new JsonResponse([
                "response" => true,
                "message" => "Le nom est un palindrome",
            ]);
        }

        return new JsonResponse([
            "response" => false,
        ]);
    }

    /**
     * Vérification du format de l'email
     * 
     * @Route("/api/email", methods={"POST"})
     * 
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function email(Request $request): JsonResponse
    {
        $email = $request->request->get('email');

        if (!$email) {
            return new JsonResponse([
                "response" => true,
                "message"  => "Pas d'email renseigné"
            ]);
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse([
                "response" => true,
                "message"  => "L'email est au bon format"
            ]);
        } else {
            return new JsonResponse([
                "response" => false,
                "email" => $email,
                "message"  => "Le format de l'email n'est pas correct"
            ]);
        }
    }
}