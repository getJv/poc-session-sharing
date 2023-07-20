<?php

namespace App\Controller;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{

    #[Route('/', name: 'app_app')]
    public function index(Request $request): Response
    {

        return $this->render('app/index.html.twig', [
            'userIdentifier' => $this->getUser()?->getUserIdentifier() ?? 'Not found...',
            'sessionId' => $informacaoDescriptografada ?? 'Not found...',
        ]);
    }
}
