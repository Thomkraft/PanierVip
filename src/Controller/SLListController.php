<?php

namespace App\Controller;

use App\Entity\SLList;
use App\Form\SLListType;
use App\Repository\SLListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/s/l/list')]
final class SLListController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->redirectToRoute('app_s_l_list_index');
    }

    #[Route(name: 'app_s_l_list_index', methods: ['GET'])]
    public function index(SLListRepository $sLListRepository): Response
    {
        return $this->render('sl_list/index.html.twig', [
            's_l_lists' => $sLListRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_s_l_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sLList = new SLList();
        $form = $this->createForm(SLListType::class, $sLList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sLList);
            $entityManager->flush();

            return $this->redirectToRoute('app_s_l_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sl_list/new.html.twig', [
            's_l_list' => $sLList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_s_l_list_show', methods: ['GET'])]
    public function show(SLList $sLList): Response
    {
        return $this->render('sl_list/show.html.twig', [
            's_l_list' => $sLList,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_s_l_list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SLList $sLList, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SLListType::class, $sLList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_s_l_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sl_list/edit.html.twig', [
            's_l_list' => $sLList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_s_l_list_delete', methods: ['POST'])]
    public function delete(Request $request, SLList $sLList, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sLList->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sLList);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_s_l_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
