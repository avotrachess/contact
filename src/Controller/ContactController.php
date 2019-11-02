<?php

namespace App\Controller;

use App\Controller\ControllerInterface;
use InvalidArgumentException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ContactController extends AbstractController implements ControllerInterface
{
    /** @var int $userId */
    protected $userId;

    /**
     * ContactController constructor.
     */
    public function __construct(SessionInterface $session)
    {
        // parent::__construct();

        $this->userId = $session->getId();
    }

    /**
     * Affichage de la liste des contacts de l'utilisateur connecté
     * 
     * @Route("/", name="contact_list")
     */
    public function index()
    {
        $contacts = [];
        if (!empty($this->userId)) {
            $contacts = $this->Contact->getContactByUser($this->userId);
        }

        return $this->render('index.html.twig', ['contacts' => $contacts]);
    }

    /**
     * Ajout d'un contact
     * 
     * @Route("/contact/add", name="contact_add")
     */
    public function add()
    {
        $error = false;
        $data = [
            'nom' => '',
            'prenom' => '',
            'email' => '',
        ];
        if (!empty($_POST)) {
            $response = $this->sanitize($_POST);
            if ($response["response"]) {
                $result = $this->Contact->create([
                    'nom'    => $response['nom'],
                    'prenom' => $response['prenom'],
                    'email'  => $response['email'],
                    'userId' => $this->userId
                ]);
                if ($result) {
                    return $this->redirectToRoute('contact_list');
                }
            } else {
                $error = true;
            }
        }
        return $this->render('add.html.twig', ['error' => $error, 'data' => $data]);
    }

    /**
     * Modification d'un contact
     */
    public function edit()
    {
        //@todo
    }

    /**
     * Suppression d'un contact
     */
    public function delete()
    {
        $result = $this->Contact->delete($_GET['id']);
        if ($result) {
            header('Location: /index.php?p=contact.index');
        }
    }

    /**
     * @param array $data
     * @return array
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function sanitize(array $data = []): array
    {
        if (empty($nom)) {
            throw new Exception('Le nom est obligatoire');
        }

        if (empty($prenom)) {
            throw new Exception('Le prenom est obligatoire');
        }

        if (empty($email)) {
            throw new Exception('Le email est obligatoire');
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Le format de l\'email est invalide');
        }

        $prenom = strtoupper($data['prenom']);
        $nom    = strtoupper($data['nom']);
        $email  = strtolower($data['email']);

        $isPalindrome = $this->apiClient('palindrome', ['name' => $nom]);
        $isEmail = $this->apiClient('email', ['email' => $email]);
        if ((!$isPalindrome->response) && $isEmail->response && $prenom) {
            return [
                'response' => true,
                'email'    => $email,
                'prenom'   => $prenom,
                'nom'      => $nom
            ];
        }
    }
}