<?php

namespace App\Form;

use App\Entity\Gouvernorat;
use App\Entity\Langue;
use App\Entity\NiveauEtude;
use App\Entity\OffreEmploi;
use App\Entity\TypeEmploi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreEmploiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('nbrePostVacant')
            ->add('remunirationPropose')
            ->add('descriptionEmploi')
            ->add('experience')
//            ->add('statut')
            ->add('gouvernorat', EntityType::class, [
                'class' => Gouvernorat::class,
                'choice_label' => 'libelle',
            ])
            ->add('langue', EntityType::class, [
                'class' => Langue::class,
                'choice_label' => 'libelle',
                'multiple' => true,
            ])
            ->add('TypeEmploi', EntityType::class, [
                'class' => TypeEmploi::class,
                'choice_label' => 'libelle',
            ])
            ->add('NiveauEtude', EntityType::class, [
                'class' => NiveauEtude::class,
                'choice_label' => 'libelle',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OffreEmploi::class,
        ]);
    }
}
