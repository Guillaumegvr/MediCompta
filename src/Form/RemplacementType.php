<?php

namespace App\Form;

use App\Entity\Remplacement;
use App\Entity\Medecin;
use App\Repository\MedecinRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemplacementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('beginAt', null, [
                'label' => 'Commence le :',
                'widget' => 'single_text',
            ])
            ->add('endAt', null, [
                'label' => 'Termine le :',
                'widget' => 'single_text',
            ])
            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'placeholder' => '--- Sélectionner ---',
                'choice_label' => function (Medecin $medecin) {
                    return $medecin->getNom() . ' ' . $medecin->getPrenom();
                },
                'query_builder' => function (MedecinRepository $medecinRepository) {
                    return $medecinRepository->createQueryBuilder('c')
                        ->orderBy('c.nom', 'ASC'); // Assurez-vous que 'nom' est le bon champ
                },
            ])
            ->add('chiffreAffaire', NumberType::class, [
                'label' => 'Chiffre d\'Affaire :',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Remplacement::class,
        ]);
    }
}