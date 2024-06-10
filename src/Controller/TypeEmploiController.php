<?php

namespace App\Controller;

use App\Entity\TypeEmploi;
use App\Form\TypeEmploiType;
use App\Repository\TypeEmploiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('Back/employeur/type/emploi')]
class TypeEmploiController extends AbstractController
{
    #[Route('/', name: 'app_type_emploi_index', methods: ['GET'])]
    public function index(TypeEmploiRepository $typeEmploiRepository): Response
    {
        return $this->render('Back/employeur/type_emploi/index.html.twig', [
            'type_emplois' => $typeEmploiRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_emploi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeEmploi = new TypeEmploi();
        $form = $this->createForm(TypeEmploiType::class, $typeEmploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeEmploi);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_emploi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/employeur/type_emploi/new.html.twig', [
            'type_emploi' => $typeEmploi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_emploi_show', methods: ['GET'])]
    public function show(TypeEmploi $typeEmploi): Response
    {
        return $this->render('Back/employeur/type_emploi/show.html.twig', [
            'type_emploi' => $typeEmploi,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_emploi_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeEmploi $typeEmploi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeEmploiType::class, $typeEmploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_emploi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/employeur/type_emploi/edit.html.twig', [
            'type_emploi' => $typeEmploi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_emploi_delete', methods: ['POST'])]
    public function delete(Request $request, TypeEmploi $typeEmploi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeEmploi->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($typeEmploi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_emploi_index', [], Response::HTTP_SEE_OTHER);
    }
}
