<?php

namespace App\Controller;

use App\Entity\Statistics;
use App\Form\StatisticsType;
use App\Repository\StatisticsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/statistics')]
final class StatisticsController extends AbstractController
{
    #[Route(name: 'app_statistics_index', methods: ['GET'])]
    public function index(StatisticsRepository $statisticsRepository): Response
    {
        return $this->render('statistics/index.html.twig', [
            'statistics' => $statisticsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_statistics_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $statistic = new Statistics();
        $form = $this->createForm(StatisticsType::class, $statistic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($statistic);
            $entityManager->flush();

            return $this->redirectToRoute('app_statistics_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('statistics/new.html.twig', [
            'statistic' => $statistic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statistics_show', methods: ['GET'])]
    public function show(Statistics $statistic): Response
    {
        return $this->render('statistics/show.html.twig', [
            'statistic' => $statistic,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_statistics_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Statistics $statistic, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatisticsType::class, $statistic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_statistics_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('statistics/edit.html.twig', [
            'statistic' => $statistic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statistics_delete', methods: ['POST'])]
    public function delete(Request $request, Statistics $statistic, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$statistic->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($statistic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_statistics_index', [], Response::HTTP_SEE_OTHER);
    }
}
