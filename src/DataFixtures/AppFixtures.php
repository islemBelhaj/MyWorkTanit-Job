<?php

namespace App\DataFixtures;

use App\Entity\Gouvernorat;
use App\Entity\Langue;
use App\Entity\NiveauEtude;
use App\Entity\TypeEmploi;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setEmail('admin@gmail.com');
        $user->setNom('admin');
        $user->setPrenom('admin');
        $user->setPassword('
        ');
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                'admin1234'

            )
        );


//        $user->setNom('admin');
//        $user->setPrenom('admin');
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();

        $gouvernorats = [
            'Nabeul',
            'Sousse',
            'Tunis',
            'Sfax',
            'Kairouan',
            'kef',
            'jandouba',
            'Seliana',
            'Gafsa',
            'kébili',
            'Mahdia'
        ];

        foreach ($gouvernorats as $libelle) {
            $gouvernorat = new Gouvernorat();
            $gouvernorat->setLibelle($libelle);

            $manager->persist($gouvernorat);
        }

        $manager->flush();


        $typesEmploi = [
            'CDD',
            'CDI',
            'CTT',
            'CUI'
        ];

        foreach ($typesEmploi as $type) {
            $typesEmploi = new TypeEmploi();
            $typesEmploi->setLibelle($type);
            $manager->persist($typesEmploi);


        }
        $manager->flush();


        $langues = [
            'Anglais',
            'Français'

        ];

        foreach($langues as $langue){
            $selectLanguage = new Langue();
            $selectLanguage->setLibelle($langue);
            $manager->persist($selectLanguage);
        }
        $manager->flush();


        $niveaux = [
            'Bac',
            'Bac+3',
            'mastère'

        ];

        foreach($niveaux as $niveau){
            $selectNiveau = new NiveauEtude();
            $selectNiveau->setLibelle($niveau);
            $manager->persist($selectNiveau);
        }
        $manager->flush();

    }


}