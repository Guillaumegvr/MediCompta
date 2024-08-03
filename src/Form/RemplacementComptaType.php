<?php

namespace App\Form;

use App\Entity\Remplacement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemplacementComptaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chiffreRealiseParRemplacement', NumberType::class, [
                'label' => 'Veuillez indiquer les revenues générés sur ce remplacement :',
                'required' => false,
            ])
            ->add('retrocession', NumberType::class, [
                'label' => 'Veuillez indiquer le montant du paiement effectué par le médecin que vous avez remplacé :',
                'required' => false,
            ])
            ->add('datePaiement', DateType::class, [
            'label' => 'Veuillez indiquer la date de Paiement :',
            'required' => false,
                'widget' => 'single_text',
                'placeholder' =>  [
                    'day' => 'Jour',  'month' => 'Mois', 'year' => 'année',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Remplacement::class,
        ]);
    }
}
