<?php

namespace App\Controller;

use App\Entity\Remplacement;
use App\Form\RemplacementType;
use App\Repository\RemplacementRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/remplacement')]
class RemplacementController extends AbstractController
{
    #[Route('/create', name: 'app_remplacement_create', methods: ['GET', 'POST'])]
    public function createRemplacement(Request $request, EntityManagerInterface $entityManager, Security $security, UserRepository $userRepository): Response
    {
        $remplacement = new Remplacement();
        $remplacement ->setDateCreation(new \DateTime('now'));

        $userId = $security->getUser()->getId();

        if (!$userId) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour créer un remplacement.');
        }

        $user = $userRepository->find($userId);
        if (!$user) {
            throw $this->createAccessDeniedException('Utilisateur non trouvé.');
        }

        $remplacement->setUser($user);

        $form = $this->createForm(RemplacementType::class, $remplacement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($remplacement);
            $entityManager->flush();

            $this -> addFlash("success", 'Remplacement ajouté avec succès');
            return $this->redirectToRoute('app_remplacement_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('remplacement/createRemplacement.html.twig', [
            'remplacement' => $remplacement,
            'form' => $form,
        ]);

    }

    #[Route("/liste", name: 'app_remplacement_liste', methods: ['GET'])]
    public function list(RemplacementRepository $remplacementRepository, Security $security): Response
    {
        $userId = $security->getUser()->getId();

        if (!$userId) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder aux données');
        }
        $remplacements = $remplacementRepository->findRemplacementsWithMedecinByUser($userId);
        return $this->render('remplacement/list.html.twig', [
            'remplacements' => $remplacements,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_remplacement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Remplacement $booking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RemplacementType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this -> addFlash("success", 'Modification effectuée');
            return $this->redirectToRoute('app_remplacement_liste', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('remplacement/edit.html.twig', [
            'remplacement' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_remplacement_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Remplacement $remplacement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$remplacement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($remplacement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_remplacement_liste', [], Response::HTTP_SEE_OTHER);
    }



}
