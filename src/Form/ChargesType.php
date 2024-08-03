<?php

namespace App\Form;

use App\Entity\Charges;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChargesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('montant', NumberType::class, [
                'label' => 'Montant en euros :',
            ])
            ->add('dateCreation', DateType::class, [
                'label' => 'Date de paiement :',
                'widget' => 'single_text',
                'data' => new \DateTime('now'),

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Charges::class,
        ]);
    }
}
