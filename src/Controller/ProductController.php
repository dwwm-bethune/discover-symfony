<?php

namespace App\Controller;

use App\Form\ProductType;
use App\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    protected $products = [];

    public function __construct()
    {
        $this->products = [
            ['name' => 'iPhone X', 'slug' => 'iphone-x', 'description' => 'Un iPhone de 2017', 'price' => 999],
            ['name' => 'iPhone XR', 'slug' => 'iphone-xr', 'description' => 'Un iPhone de 2018', 'price' => 1099],
            ['name' => 'iPhone XS', 'slug' => 'iphone-xs', 'description' => 'Un iPhone de 2018', 'price' => 1199],
        ];
    }

    #[Route('/product/{page}', name: 'app_product', requirements: ['page' => '\d+'])]
    public function index(Request $request, $page = 1): Response
    {
        $products = array_filter($this->products, function ($product) use ($request) {
            if (! $price = $request->get('price')) {
                $price = INF;
            }

            return $product['price'] <= $price;
        });

        // Pagination
        // Le array chunk crée des groupes de tableaux (15 => 3 array de 5)
        // L'index est la page - 1 => Page 1 => index 0
        $chunk = array_chunk($products, 2);
        $products = $chunk[$page - 1] ?? null;

        if (! $products) {
            throw $this->createNotFoundException();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'page' => $page,
            'total' => count($chunk),
        ]);
    }

    #[Route('/product/random', name: 'app_product_random')]
    public function random(): Response
    {
        $product = $this->products[array_rand($this->products)];

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/create', name: 'app_product_create')]
    public function create(Request $request): Response
    {
        $product = new Product();
        dump($product);

        $form = $this->createForm(ProductType::class, $product);

        // Ne pas oublier de faire le lien entre la
        // request et le form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($product);
            // Envoi un mail, ajout dans la BDD...
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/{slug}', name: 'app_product_show')]
    public function show($slug): Response
    {
        $product = array_values(array_filter($this->products, function ($product) use ($slug) {
            return $product['slug'] === $slug;
        }))[0] ?? null;

        if (! $product) {
            throw $this->createNotFoundException();
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product.json', name: 'app_product_api')]
    public function api(): Response
    {
        return $this->json($this->products);
    }

    #[Route('/order/{slug}', name: 'app_order')]
    public function order($slug)
    {
        $product = array_values(array_filter($this->products, function ($product) use ($slug) {
            return $product['slug'] === $slug;
        }))[0] ?? null;

        if (! $product) {
            throw $this->createNotFoundException();
        }

        $this->addFlash('success',
            'Nous avons bien pris en compte votre commande '.$product['name'].' de '.$product['price'].' €'
        );

        return $this->redirectToRoute('app_product');
    }
}
