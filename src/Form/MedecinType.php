<?php

namespace App\Form;

use App\Entity\Medecin;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedecinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'label' => 'Nom :',
                'required' => true,
            ])
            ->add('Prenom', TextType::class, [
                'label' => 'Prénom :',
                'required' => true,
             ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse :',
                'required' => true,
            ])
            ->add('codePostal', IntegerType::class, [
                'label' => 'Code Postal :',
                'required' => true,
             ])
            ->add('ville',TextType::class, [
                'label' => 'Ville :',
                'required' => true,
            ])
            ->add('adresseMail', EmailType::class, [
                'label' => 'Adresse mail :',
                'required' => false,
            ])
            ->add('numeroTel', IntegerType::class, [
                'label' => 'Numéro de téléphone : ',
                   'required' => false,
            ])
            ->add('logiciel', TextType::class, [
                'label' => 'Logiciel :',
                'required' => false,
            ])
            ->add('secretaire', CheckboxType::class, [
                'label' => 'Cochez si le médecin dispose d\'un secrétariat',
                'required' => false,
            ])
            ->add('retrocession', IntegerType::class, [
                'label' => 'Pourcentage de rétrocession : ',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medecin::class,
        ]);
    }
}
