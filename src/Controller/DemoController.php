<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route(
        '/demo/{page}',
        name: 'demo',
        requirements: ['page' => '[0-9]+']
    )]
    public function other($page = 1): Response
    {
        return $this->render('demo/index.html.twig', [
            'letters' => ['d', 'e', 'f'],
            'page' => $page,
        ]);
    }

    #[Route(
        '/demo/{title}',
        name: 'demo_show',
        requirements: ['page' => '[A-Za-z-]+']
    )]
    public function show($title): Response
    {
        return $this->render('demo/show.html.twig', [
            'title' => $title,
        ]);
    }
}
