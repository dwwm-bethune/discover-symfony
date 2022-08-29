<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    #[Route('/hello', name: 'hello')]
    public function index(): Response
    {
        $name = 'Fiorella';
        dump($name);

        return $this->render('welcome/index.html.twig', [
            'name' => $name,
        ]);
    }
}
