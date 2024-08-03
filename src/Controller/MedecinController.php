<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Entity\User;
use App\Form\MedecinType;
use App\Form\SearchMedecinType;
use App\Form\UserType;
use App\Repository\MedecinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class MedecinController extends AbstractController
{
    #[Route('/medecin/create', name: 'app_medecin_create')]
    public function createMedecin(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $userId = $security->getUser()->getId();

        if (!$userId) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder aux données');
        }

        $medecin = new Medecin();
        $medecin->setDateCreation(new \DateTime());

        $form=$this->createForm(MedecinType::class, $medecin);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager ->persist($medecin);
            $entityManager->flush();


            $this -> addFlash("success", 'Medecin ajouté avec succès');
            return $this->redirectToRoute('app_remplacement_create');
        }

        return $this->render('medecin/createMedecin.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/medecin/liste', name: 'app_medecin_liste')]
    public function afficherMedecins(MedecinRepository $medecinRepository, Security $security, Request $request, EntityManagerInterface $entityManager): Response
    {
        $userId = $security->getUser()->getId();
        if (!$userId) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder aux données');
        }

        $medecin = new Medecin();
        $form =$this->createForm(SearchMedecinType::class);
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $nom = $form -> get('nom') -> getData();
        $medecins = $entityManager -> getRepository(Medecin::class)->findBy(['nom' => $nom]);

        if($medecins){
            return $this->render('medecin/liste.html.twig', [
                'medecins' => $medecins,
                'form' => $form->createView()
            ]);
        }else {
            return $this->render('medecin/liste.html.twig', [
                'medecins' => 'aucun médecin trouvé.',
                'form' => $form->createView()
            ]);
        }
        }
        $medecins = $medecinRepository->findAll();
        return $this->render('medecin/liste.html.twig', [
            'medecins' => $medecins,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/medecin/{id}/edit', name: 'app_medecin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Medecin $medecin, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager ->persist($medecin);
            $entityManager->flush();
            $this -> addFlash("success", 'Modification effectuée');
            return $this->redirectToRoute('app_medecin_liste', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('medecin/edit.html.twig', [
            'medecin' => $medecin,
            'form' => $form,
        ]);
    }
}
