<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Entity\User;
use App\Form\MedecinType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class MedecinController extends AbstractController
{
    #[Route('/create/medecin', name: 'app_create_medecin')]
    public function createUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $medecin = new Medecin();
        $medecin->setDateCreation(new \DateTime());

        $form=$this->createForm(MedecinType::class, $medecin);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager ->persist($medecin);
            $entityManager->flush();


            $this -> addFlash("success", 'Medecin ajouté avec succès');
            return $this->redirectToRoute('app_create_remplacement');
        }

        return $this->render('medecin/createMedecin.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
