<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Api extends AbstractController
{
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
        if ($this->getRequestMethod() != "POST") {
            return new JsonResponse('', 406);
        }

        $name = $this->request['name'];
        // TODO ecrire un objet palindrome
        //$palindrome = new Palindrome($name);

        if ($name) {
            // TODO ecrire la methode isValid() de l'objet palindrome et la tester avec PHPUnit
            /*
            if ($palindrome->isValid()) {
                $this->response($this->json(["response" => true]), 200);
            } else {
                $this->response($this->json(["response" => false]), 200);
            }
            */
        }
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