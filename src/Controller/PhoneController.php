<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\PhoneType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhoneController extends AbstractController
{
    #[Route('/phone', name: 'app_phone')]
    public function index(ManagerRegistry $doctrine, ProductRepository $repository)
    {
        // $doctrine->getRepository(Product::class)->findAll();
        $products = $repository->findAll();

        return $this->render('phone/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/phone/create', name: 'app_phone_new')]
    public function create(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $manager)
    {
        $product = new Product();
        $form = $this->createForm(PhoneType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $manager = $doctrine->getManager();
            $manager->persist($product);
            $manager->flush();

            $this->addFlash('success', $product->getName().' a été créé.');

            return $this->redirectToRoute('app_phone');
        }

        return $this->render('phone/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/phone/{id}', name: 'app_phone_show')]
    public function show(ProductRepository $repository, Product $product)
    {
        // $product = $repository->find($id);

        // if (! $product) {
        //     throw $this->createNotFoundException();
        // }

        return $this->render('phone/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/phone/{id}/edit', name: 'app_phone_edit')]
    public function update(Product $product, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(PhoneType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', $product->getName().' a été modifié.');

            return $this->redirectToRoute('app_phone');
        }

        return $this->render('phone/update.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    #[Route('/phone/{id}/delete', name: 'app_phone_delete')]
    public function delete(Product $product, EntityManagerInterface $manager)
    {
        $manager->remove($product);
        $manager->flush();

        return $this->redirectToRoute('app_phone');
    }
}
