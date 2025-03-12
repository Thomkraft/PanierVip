<?php

namespace App\Controller;

use App\Entity\Statistics;
use App\Form\StatisticsType;
use App\Repository\ProductRepository;
use App\Repository\StatisticsRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Product;

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


    #[Route("/statistics/avg", name: 'stats_avg', methods: ['GET'])]
    public function getAvgProductCost(ProductRepository $productRepo): JsonResponse {
        $products = $productRepo->findAll();
        $totalCost = 0;

        foreach ($products as $product) { $totalCost += $product->getPrice(); }

        $avg = $totalCost / sizeof($products);

        return new JsonResponse(["AVERAGE" => $avg]);
    }


    #[Route("/statistics/total-cost", name: "total_cost", methods: ['GET'])]
    public function getTotalCost(ProductRepository $productRepo): JsonResponse { 
        $products = $productRepo->findAll();
        $totalCost = 0;

        foreach ($products as $product) { $totalCost += $product->getPrice(); }

        return new JsonResponse(["TOTAL_COST" => $totalCost]);
    }

    #[Route("/statistics/mep", name: "most_expensive_product", methods: ['GET'])]
    public function getMostExpProduct(ProductRepository $productRepo): JsonResponse {
        $products = $productRepo->findAll();
        $mostExpProduct = new Product();
        $token = $mostExpProduct; // will hold the dummy ref of 'new Product()'

        foreach ($products as $product) {
            if ($mostExpProduct == $token) { $mostExpProduct = $product; } 
            else {
                if ($mostExpProduct->getPrice() < $product->getPrice())
                    $mostExpProduct = $product;
            }
        }

        return new JsonResponse(["MOST_EXP_PRODUCT" => $mostExpProduct]);
    }
}
