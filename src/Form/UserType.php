<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail :',
                'required' => true,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe :',
                'required' => true,
            ])
            ->add('Nom', TextType::class, [
                'label' => 'Nom :',
                'required' => true,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom :',
                'required' => true,
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse :',
                'required' => true,
            ])
            ->add('codepostal', IntegerType::class, [
                'label' => 'Code Postal :',
                'required' => true,
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville :',
                'required' => true,
            ])
            ->add('no_departement', IntegerType::class, [
                'label' => 'Numéro de département :',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
