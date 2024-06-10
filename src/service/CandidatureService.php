<?php

namespace App\service;

use App\Entity\Candidature;
use Doctrine\ORM\EntityManagerInterface;

class CandidatureService
{
    public EntityManagerInterface $em ;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em ;
    }

    public function createdCandidature($cv , $user , $offreEmploi):Candidature
    {
        $candidature = new Candidature();

        $candidature->setCv($cv);
        $candidature->setUser($user);
        $candidature->setOffreEmploi($offreEmploi);

        $this->em->persist($candidature);
        $this->em->flush();
        return $candidature;
    }





}