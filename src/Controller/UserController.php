<?php

namespace App\Controller;

use App\Controller\MainController;
use App;

class UserController extends MainController
{
    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function login()
    {
        $errors = false;

        if (!empty($_POST)) {

            if ($this->auth->login($_POST['login'], $_POST['password'])) {
                header('Location: index.php?p=contact.index');
            } else {
                $errors = true;
            }
        }
        echo $this->twig->render('login.html.twig', ['errors' => $errors]);
    }
}