<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class CreateUserController extends AbstractController
{
    #[Route('/create/user', name: 'app_create_user')]
    public function createUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $user -> setRoles(['ROLE_USER']);
        $user -> setDateCreation(new \DateTime('now'));

        $form=$this->createForm(UserType::class, $user);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $plainTextPassword = $user -> getPassword();
            $hashedPassword = $passwordHasher->hashPassword($user, $plainTextPassword);
            $user -> setPassword($hashedPassword);
            $entityManager ->persist($user);
            $entityManager->flush();


            $this -> addFlash("success", 'Utilisateur ajouté avec succès');
            return $this->redirectToRoute('app_login_index');
        }

        return $this->render('create_user/createUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
