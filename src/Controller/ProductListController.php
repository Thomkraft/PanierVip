<?php

namespace App\Controller;

use App\Entity\ProductList;
use App\Form\ProductListType;
use App\Repository\ProductListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product/list')]
final class ProductListController extends AbstractController
{
    #[Route(name: 'app_product_list_index', methods: ['GET'])]
    public function index(ProductListRepository $productListRepository): Response
    {
        return $this->render('product_list/index.html.twig', [
            'product_lists' => $productListRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $productList = new ProductList();
        $form = $this->createForm(ProductListType::class, $productList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($productList);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_list/new.html.twig', [
            'product_list' => $productList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_list_show', methods: ['GET'])]
    public function show(ProductList $productList): Response
    {
        return $this->render('product_list/show.html.twig', [
            'product_list' => $productList,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProductList $productList, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductListType::class, $productList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_list/edit.html.twig', [
            'product_list' => $productList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_list_delete', methods: ['POST'])]
    public function delete(Request $request, ProductList $productList, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productList->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($productList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
