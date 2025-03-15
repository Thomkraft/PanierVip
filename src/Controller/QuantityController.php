<?php

namespace App\Controller;

use App\Entity\Quantity;
use App\Form\QuantityType;
use App\Repository\QuantityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quantity')]
final class QuantityController extends AbstractController
{
    #[Route(name: 'app_quantity_index', methods: ['GET'])]
    public function index(QuantityRepository $quantityRepository): Response
    {
        return $this->render('quantity/index.html.twig', [
            'quantities' => $quantityRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quantity_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $quantity = new Quantity();
        $form = $this->createForm(QuantityType::class, $quantity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quantity);
            $entityManager->flush();

            return $this->redirectToRoute('app_quantity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quantity/new.html.twig', [
            'quantity' => $quantity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quantity_show', methods: ['GET'])]
    public function show(Quantity $quantity): Response
    {
        return $this->render('quantity/show.html.twig', [
            'quantity' => $quantity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quantity_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quantity $quantity, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuantityType::class, $quantity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_quantity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quantity/edit.html.twig', [
            'quantity' => $quantity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quantity_delete', methods: ['POST'])]
    public function delete(Request $request, Quantity $quantity, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quantity->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($quantity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quantity_index', [], Response::HTTP_SEE_OTHER);
    }
}
