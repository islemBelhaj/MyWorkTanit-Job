<?php

namespace App\Controller;

use App\Entity\OffreEmploi;
use App\Repository\OffreEmploiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminBackController extends AbstractController
{
    #[Route('Back/admin/back/', name: 'app_admin_back', methods: ['GET'])]
    public function index(OffreEmploiRepository $offreEmploiRepository): Response
    {
        return $this->render('Back/admin_back/index.html.twig', [
            'offres' => $offreEmploiRepository->findAll(),
        ]);
    }

    #[Route('/admin/back/{id}', name: 'app_admin_back_id', methods: ['GET'])]
    public function editStatut(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $offre = $em->getRepository(OffreEmploi::class)->find($id);

        if (!$offre) {
            throw $this->createNotFoundException('No offer found for id ' . $id);
        }

        if ($request->query->get('idRefus')) {
            $offre->setStatut(2);
        } elseif ($request->query->get('idAccept')) {
            $offre->setStatut(1);
        } else {
            throw $this->createNotFoundException('Invalid action');
        }

        $em->flush();

        return $this->redirectToRoute('app_admin_back');
    }
}
