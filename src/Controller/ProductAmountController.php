<?php

namespace App\Controller;

use App\Entity\ProductAmount;
use App\Form\ProductAmountType;
use App\Repository\ProductAmountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product/amount')]
final class ProductAmountController extends AbstractController
{
    #[Route(name: 'app_product_amount_index', methods: ['GET'])]
    public function index(ProductAmountRepository $productAmountRepository): Response
    {
        return $this->render('product_amount/index.html.twig', [
            'product_amounts' => $productAmountRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_amount_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $productAmount = new ProductAmount();
        $form = $this->createForm(ProductAmountType::class, $productAmount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($productAmount);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_amount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_amount/new.html.twig', [
            'product_amount' => $productAmount,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_amount_show', methods: ['GET'])]
    public function show(ProductAmount $productAmount): Response
    {
        return $this->render('product_amount/show.html.twig', [
            'product_amount' => $productAmount,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_amount_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProductAmount $productAmount, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductAmountType::class, $productAmount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product_amount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_amount/edit.html.twig', [
            'product_amount' => $productAmount,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_amount_delete', methods: ['POST'])]
    public function delete(Request $request, ProductAmount $productAmount, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productAmount->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($productAmount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_amount_index', [], Response::HTTP_SEE_OTHER);
    }
}
