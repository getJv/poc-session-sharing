<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;


class HomeController extends AbstractController
{
    public function __construct(
        private TokenStorageInterface $tokenStorage
    ){
    }

    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('login/index.html.twig');
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {

        return $this->render('home/index.html.twig', [
            'userIdentifier' => $this->getUser()?->getUserIdentifier() ?? 'Not found...',
            'userToken' => $this->tokenStorage->getToken() ?? 'Not found...',

        ]);
    }
}
