<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;

class PseudoController extends AbstractController
{
    #[Route('/set_pseudo', name: 'app_set_pseudo')]
    public function set_pseudo(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if ($user->getPseudo()) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createFormBuilder($user)
            ->add('pseudo', TextType::class, ['label' => 'Choisissez un pseudo'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('pseudo/set_pseudo.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}