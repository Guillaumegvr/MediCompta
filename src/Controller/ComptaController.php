<?php

namespace App\Controller;

use App\Entity\Remplacement;
use App\Form\RemplacementComptaType;
use App\Repository\RemplacementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ComptaController extends AbstractController
{
    #[Route('/comptabilite/liste', name: 'app_comptabilite_liste', methods: ['GET'])]
    public function afficherRemplacementsEtAjouterCompta(RemplacementRepository $remplacementRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $remplacements = $remplacementRepository->findRemplacementsAvecSommesDesc();
        
        return $this->render('comptabilite/liste.html.twig',  [
                'remplacements' => $remplacements,
            ]
        );
    }


#[Route('/comptabilite/{id}/edit', name: 'app_comptabilite_edit', methods: ['GET', 'POST'])]
    public function afficherRemplacementsEtAjouterCompta3($id, RemplacementRepository $remplacementRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $remplacement = $remplacementRepository->find($id);


        $form = $this->createForm(RemplacementComptaType::class, $remplacement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($remplacement);
            $entityManager->flush();

            $this -> addFlash("success", 'Mise à jour effécutée');
            return $this->redirectToRoute('app_comptabilite_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comptabilite/edit.html.twig',  [
                'remplacements' => $remplacement,
                'form'=> $form->createView(),
            ]
        );
    }
}
