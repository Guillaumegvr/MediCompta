<?php

namespace App\Form;

use App\Entity\Remplacement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemplacementComptaDatesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('dateDebut', DateType::class, [
            'label' => 'Periode du :',
            'widget' => 'single_text',
            'data' => new \DateTime('first day of January this year'),
        ])
        ->add('dateFin', DateType::class, [
            'label' => 'au :',
            'widget' => 'single_text',
            'data' => new \DateTime('now'),
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Remplacement::class,
        ]);
    }
}
