<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriCandidatType;
use App\Form\InscriEmpoloyeurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscriEmployeur', name: 'app_register_employeur')]
    #[Route('/inscriCandidat', name: 'app_register_candidat')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SluggerInterface $slugger, string $brochuresDirectory = ''): Response
    {
        if ($request->getPathInfo() === '/inscriCandidat') {
            $user = new User();
            $form = $this->createForm(InscriCandidatType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $user->setRoles(['ROLE_CANDIDAT']);
                $entityManager->persist($user);
                $entityManager->flush();

                // do anything else you need here, like send an email

                return $this->redirectToRoute('app_login');
            }

            return $this->render('registration/inscriCandidat.html.twig', [
                'registrationForm' => $form,
            ]);
        } elseif ($request->getPathInfo() === '/inscriEmployeur') {
            $user = new User();
            $form = $this->createForm(InscriEmpoloyeurType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $imageFile = $form->get('logo')->getData();

                if ($imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                    try {
                        $imageFile->move($this->getParameter('brochures_directory')[0], $newFilename);
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
                }
                $user->setLogo($newFilename);
                    // encode the plain password
                    $user->setPassword(
                        $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('plainPassword')->getData()
                        )
                    );
//                $user->setLogo('oui');
                    $user->setRoles(['ROLE_EMPLOYEUR']);
                    $entityManager->persist($user);
                    $entityManager->flush();

                    // do anything else you need here, like send an email

                    return $this->redirectToRoute('app_login');
                }

                return $this->render('registration/inscriEmployeur.html.twig', [
                    'registrationFormEmployeur' => $form,
                ]);
            }

            // Si aucune des routes ci-dessus ne correspond, on retourne une réponse par défaut
            return new Response('', Response::HTTP_NOT_FOUND);
        }

    }
