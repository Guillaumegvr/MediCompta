<?php

namespace App\Form;

use App\Entity\Remplacement;
use App\Entity\Medecin;
use App\Repository\MedecinRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemplacementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'label' => 'Periode du :',
                'widget' => 'single_text',
                'data' => new \DateTime('now'),
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'au :',
                'widget' => 'single_text',
                'data' => new \DateTime('now'),
            ])
            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'label' => 'Médecin',
                'placeholder' => '--- Sélectionner ---',
                'choice_label' => function (Medecin $medecin) {
                    return $medecin->getNom() . ' ' . $medecin->getPrenom();
                },
                'query_builder' => function (MedecinRepository $medecinRepository) {
                    return $medecinRepository->createQueryBuilder('c')
                        ->orderBy('c.nom', 'ASC');
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Remplacement::class,
        ]);
    }

}
