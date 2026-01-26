<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RealisateurController extends AbstractController
{
    #[Route('/realisateur', name: 'app_realisateur')]
    public function index(): Response
    {
        return $this->render('realisateur/index.html.twig', [
            'controller_name' => 'RealisateurController',
        ]);
    }
}
