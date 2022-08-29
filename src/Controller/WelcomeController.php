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

    #[Route(
        '/hello/{name}',
        name: 'hello_show',
        requirements: ['name' => '[a-z]{3,8}']
    )]
    public function show($name)
    {
        return $this->render('welcome/index.html.twig', [
            'name' => ucfirst($name),
        ]);
    }
}
