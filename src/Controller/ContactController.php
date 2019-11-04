<?php

namespace App\Controller;

use App\Controller\ControllerInterface;
use InvalidArgumentException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Models\ContactModel;
use Symfony\Component\HttpFoundation\Request;
use App\Components\Api\ApiService;

/**
 * Class ContactController
 */
class ContactController extends AbstractController implements ControllerInterface
{
    /** @var int $userId */
    protected $userId;

    /** @var ContactModel $contact */
    protected $contact;

    /** @var ApiService $apiService */
    protected $apiService;

    /**
     * ContactController constructor.
     */
    public function __construct(ContactModel $contact, ApiService $apiService)
    {
        //1 pour le utilisateur pour tester car pas d'authentification
        $this->userId = 1;
        $this->contact = $contact;
        $this->apiService = $apiService;
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
            $contacts = $this->contact->getContactByUser($this->userId);
        }

        return $this->render('index.html.twig', ['contacts' => $contacts]);
    }

    /**
     * Ajout d'un contact
     * 
     * @Route("/contact/add", name="contact_add")
     */
    public function add(Request $request)
    {
        $error = false;
        $data = [
            'nom' => $request->request->get('nom') ,
            'prenom' => $request->request->get('prenom') ,
            'email' => $request->request->get('email'),
        ];

        if (!is_null($data['nom']) && !is_null($data['prenom']) && !is_null($data['email'])) {
            $response = $this->sanitize($data);
            if ($response["response"]) {
                $result = $this->contact->create([
                    'nom'    => ucfirst($response['nom']),
                    'prenom' => ucfirst($response['prenom']),
                    'email'  => strtolower($response['email']),
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
        $result = $this->contact->delete($_GET['id']);
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
        $prenom = strtoupper($data['prenom']);
        $nom    = strtoupper($data['nom']);
        $email  = strtolower($data['email']);

        if (empty($nom)) {
            throw new Exception('Le nom est obligatoire');
        }

        if (empty($prenom)) {
            throw new Exception('Le prenom est obligatoire');
        }

        if (empty($email)) {
            throw new Exception('Le email est obligatoire');
        }

        $isLastNamePalindrome = $this->apiService->isPalindrome($nom);
        $isFirstNamePalindrome = $this->apiService->isPalindrome($prenom);
        $isEmail = $this->apiService->isEmail($email);

        if ((!$isPalindrome) && $isEmail && (!$isFirstNamePalindrome)) {
            return [
                'response' => true,
                'email'    => $email,
                'prenom'   => $prenom,
                'nom'      => $nom
            ];
        }

        return [
            'response' => false,
            'email'    => $email,
            'prenom'   => $prenom,
            'nom'      => $nom
        ];
    }
}