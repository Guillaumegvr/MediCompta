<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Remplacement;
use App\Entity\User;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemplacementComptaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('chiffreRealise', NumberType::class, [
                'label' => 'Veuillez indiquer les revenues générés sur ce remplacement :',
                'required' => false,
            ])
            ->add('paiementEffectue', NumberType::class, [
                'label' => 'Veuillez indiquer le montant du paiement effectué par le médecin que vous avez remplacé :',
                'required' => false,
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
