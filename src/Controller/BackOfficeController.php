<?php

namespace App\Controller;

use App\Repository\OffreEmploiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BackOfficeController extends AbstractController
{

    #[Route('/redirection', name: 'app_redirection')]
    public function index(){
        $roles = $this->getUser()->getRoles();
        if (in_array("ROLE_ADMIN", $roles)) {
            return  $this->redirectToRoute('app_admin_back') ;
        }
        elseif (in_array("ROLE_CANDIDAT", $roles)) {
            return   $this->redirectToRoute('app_candidature_index') ;
        }
        elseif (in_array("ROLE_EMPLOYEUR", $roles)) {
            return   $this->redirectToRoute('app_offre_emploi_index') ;
        }
    }

    #[Route('/admin', name: 'app_admin')]
//    #[Route('/candidat', name: 'app_candidat')]
//    #[Route('/employeur', name: 'app_employeur')]
    public function admin(): Response
    {
        return $this->render('Back/admin/admin.html.twig', [

        ]);
    }
    #[Route('employeur/employeur', name: 'app_employeur')]

    public function employeur(OffreEmploiRepository $offreEmploiRepository): Response
    {
        return $this->render('Back/employeur/offre_emploi/index.html.twig', [
            'offre_emplois' => $offreEmploiRepository->findAll(),

        ]);
    }
    #[Route('/candidat/candidat', name: 'app_candidat')]

    public function condidat(): Response
    {
        return $this->render('Back/candidat/candidat.html.twig', [

        ]);
    }
}
