<?php

namespace App\Controller;

use App\Entity\ListedProduct;
use App\Form\ListedProductType;
use App\Repository\ListedProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/listed/product')]
final class ListedProductController extends AbstractController
{
    #[Route(name: 'app_listed_product_index', methods: ['GET'])]
    public function index(ListedProductRepository $listedProductRepository): Response
    {
        return $this->render('listed_product/index.html.twig', [
            'listed_products' => $listedProductRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_listed_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $listedProduct = new ListedProduct();
        $form = $this->createForm(ListedProductType::class, $listedProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($listedProduct);
            $entityManager->flush();

            return $this->redirectToRoute('app_listed_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('listed_product/new.html.twig', [
            'listed_product' => $listedProduct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_listed_product_show', methods: ['GET'])]
    public function show(ListedProduct $listedProduct): Response
    {
        return $this->render('listed_product/show.html.twig', [
            'listed_product' => $listedProduct,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_listed_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ListedProduct $listedProduct, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ListedProductType::class, $listedProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_listed_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('listed_product/edit.html.twig', [
            'listed_product' => $listedProduct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_listed_product_delete', methods: ['POST'])]
    public function delete(Request $request, ListedProduct $listedProduct, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listedProduct->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($listedProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_listed_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
