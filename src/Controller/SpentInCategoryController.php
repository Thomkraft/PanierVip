<?php

namespace App\Controller;

use App\Entity\SpentInCategory;
use App\Form\SpentInCategoryType;
use App\Repository\SpentInCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/spent/in/category')]
final class SpentInCategoryController extends AbstractController
{
    #[Route(name: 'app_spent_in_category_index', methods: ['GET'])]
    public function index(SpentInCategoryRepository $spentInCategoryRepository): Response
    {
        return $this->render('spent_in_category/index.html.twig', [
            'spent_in_categories' => $spentInCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_spent_in_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $spentInCategory = new SpentInCategory();
        $form = $this->createForm(SpentInCategoryType::class, $spentInCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($spentInCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_spent_in_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spent_in_category/new.html.twig', [
            'spent_in_category' => $spentInCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spent_in_category_show', methods: ['GET'])]
    public function show(SpentInCategory $spentInCategory): Response
    {
        return $this->render('spent_in_category/show.html.twig', [
            'spent_in_category' => $spentInCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_spent_in_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SpentInCategory $spentInCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SpentInCategoryType::class, $spentInCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_spent_in_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('spent_in_category/edit.html.twig', [
            'spent_in_category' => $spentInCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_spent_in_category_delete', methods: ['POST'])]
    public function delete(Request $request, SpentInCategory $spentInCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spentInCategory->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($spentInCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_spent_in_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
