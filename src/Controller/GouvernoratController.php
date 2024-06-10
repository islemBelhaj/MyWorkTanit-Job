<?php

namespace App\Controller;

use App\Entity\Gouvernorat;
use App\Form\GouvernoratType;
use App\Repository\GouvernoratRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('employeur/gouvernorat')]
class GouvernoratController extends AbstractController
{
    #[Route('/', name: 'app_gouvernorat_index', methods: ['GET'])]
    public function index(GouvernoratRepository $gouvernoratRepository): Response
    {
        return $this->render('Back/employeur/gouvernorat/index.html.twig', [
            'gouvernorats' => $gouvernoratRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_gouvernorat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gouvernorat = new Gouvernorat();
        $form = $this->createForm(GouvernoratType::class, $gouvernorat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gouvernorat);
            $entityManager->flush();

            return $this->redirectToRoute('app_gouvernorat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/employeur/gouvernorat/new.html.twig', [
            'gouvernorat' => $gouvernorat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gouvernorat_show', methods: ['GET'])]
    public function show(Gouvernorat $gouvernorat): Response
    {
        return $this->render('Back/employeur/gouvernorat/show.html.twig', [
            'gouvernorat' => $gouvernorat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gouvernorat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gouvernorat $gouvernorat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GouvernoratType::class, $gouvernorat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_gouvernorat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/employeur/gouvernorat/edit.html.twig', [
            'gouvernorat' => $gouvernorat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gouvernorat_delete', methods: ['POST'])]
    public function delete(Request $request, Gouvernorat $gouvernorat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gouvernorat->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($gouvernorat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gouvernorat_index', [], Response::HTTP_SEE_OTHER);
    }
}