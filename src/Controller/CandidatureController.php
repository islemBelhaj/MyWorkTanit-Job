<?php

namespace App\Controller;

use App\Entity\Candidature;
use App\Entity\OffreEmploi;
use App\Form\CandidatureType;
use App\Repository\CandidatureRepository;
use App\Repository\OffreEmploiRepository;
use App\service\CandidatureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/candidat/candidature')]
class CandidatureController extends AbstractController
{
    #[Route('/', name: 'app_candidature_index', methods: ['GET'])]
    public function index(OffreEmploiRepository $offreEmploiRepository): Response
    {
        return $this->render('Back/candidat/candidature/index.html.twig', [
            'offre_emplois' => $offreEmploiRepository->findBy(['statut' => 0]),
        ]);
    }





    #[Route('/new/{id}', name: 'app_candidature_new', methods: ['GET', 'POST'])]
    public function add(CandidatureService $candidatureService, Request $request, CandidatureRepository $candidatureRepository, SluggerInterface $slugger ,EntityManagerInterface $entityManager ,$id): Response
    {

        $candidature = new Candidature();

        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('cv')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move($this->getParameter('pdf_space')[0], $newFilename);
                } catch (FileException $e) {
                }
            }
            $candidature->setCv($newFilename);
            $user = $this->getUser();
            $candidature->setUser($user);


            $cv = $form->get('cv')->getData();
            $offreEmploi = $entityManager->getRepository(OffreEmploi::class)->find($id);
//            $candidature->setOffreEmploi($offreEmploi);
//            $offreEmploi = $candidatureRepository->find("offreEmploi");



                $candidatureService->createdCandidature($cv, $user, $offreEmploi);

                return $this->redirect("/candidat/candidature");


        } else {
            $error = 'File upload failed or no file uploaded.';
        }


        return $this->render('Back/candidat/candidature/new.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }


    #[Route('/{id}', name: 'app_candidature_show', methods: ['GET'])]
    public function show(Candidature $candidature): Response
    {
        return $this->render('Back/candidat/candidature/show.html.twig', [
            'candidature' => $candidature,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_candidature_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Candidature $candidature, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CandidatureType::class, $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back/candidat/candidature/edit.html.twig', [
            'candidature' => $candidature,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_candidature_delete', methods: ['POST'])]
    public function delete(Request $request, Candidature $candidature, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidature->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($candidature);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_candidature_index', [], Response::HTTP_SEE_OTHER);
    }
}
