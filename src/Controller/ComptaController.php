<?php

namespace App\Controller;

use App\Entity\Charges;
use App\Entity\Remplacement;
use App\Entity\User;
use App\Form\ChargesType;
use App\Form\RemplacementComptaDatesType;
use App\Form\RemplacementComptaType;
use App\Repository\ChargesRepository;
use App\Repository\RemplacementRepository;
use App\Service\ComptabiliteService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ComptaController extends AbstractController
{
    #[Route('/comptabilite/liste', name: 'app_comptabilite_liste', methods: ['GET'])]
    public function afficherRemplacementsAction(RemplacementRepository $remplacementRepository, Security $security): Response
    {
        $userId = $security->getUser()->getId();

        if (!$userId) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder aux données');
        }

        $remplacements = $remplacementRepository->findRemplacementsNonPayesAvecSommesDescByUSer($userId);

        return $this->render('comptabilite/liste.html.twig', [
                'remplacements' => $remplacements,
            ]
        );
    }

    #[Route('/comptabilite/{id}/edit', name: 'app_comptabilite_edit', methods: ['GET', 'POST'])]
    public function editRemplacementComptabiliteAction($id, RemplacementRepository $remplacementRepository, Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $remplacement = $remplacementRepository->find($id);

        if (!$remplacement) {
            throw $this->createNotFoundException('Le remplacement demandé n\'existe pas.');
        }

        $user = $security->getUser();

        $form = $this->createForm(RemplacementComptaType::class, $remplacement);
        $form->handleRequest($request);
        $user = $entityManager->getRepository(User::class)->find($user->getId());

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder aux données');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $remplacement->setSalaireVerse($remplacement->getRetrocession() * ($user->getPourcentageSalaireVerse() / 100));
            $entityManager->persist($remplacement);
            $entityManager->flush();

            $this->addFlash("success", 'Mise à jour effécutée');
            return $this->redirectToRoute('app_comptabilite_liste', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comptabilite/edit.html.twig', [
                'remplacements' => $remplacement,
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/comptabilite/bilan', name: 'app_comptabilite_bilan', methods: ['GET', 'POST'])]
    public function affichercomptabiliteBilan(ComptabiliteService $comptabiliteService, Security $security, Request $request, EntityManagerInterface $entityManager): Response
    {
        $userId = $security->getUser()->getId();

        if (!$userId) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder aux données');
        }
        $remplacement = new Remplacement();
        $form = $this->createForm(RemplacementComptaDatesType::class, $remplacement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $dateDebut = $remplacement->getDateDebut();
            $dateFin = $remplacement->getDateFin();

            $remplacements = $comptabiliteService->findByDatesAndUser($userId, $dateDebut, $dateFin);

            $paiementEffectues = array_map(function ($remplacement) {
                return $remplacement->getRetrocession();
            }, $remplacements);

            $beneficesPeriodeSelectionnee = array_sum($paiementEffectues);
            $user = $entityManager->getRepository(User::class)->find($userId);
            $salaireVersePeriodeSelectionnee = $beneficesPeriodeSelectionnee * ($user->getPourcentageSalaireVerse() / 100);

            $chargesPeriodeSelectionnee = $comptabiliteService->finChargesByDatesAndUser($userId, $dateDebut, $dateFin);


            return $this->render('comptabilite/bilan.html.twig', [
                'remplacements' => $remplacements,
                'form' => $form->createView(),
                'beneficesPeriodeSelectionnee' => $beneficesPeriodeSelectionnee,
                'salairePeriodeSelectionnee' => $salaireVersePeriodeSelectionnee,
                'chargesPeriodeSelectionnee' => $chargesPeriodeSelectionnee,
            ]);
        } else {
            $remplacementsAnneeEnCours = $comptabiliteService->findRemplacementAnneeEnCoursByUser($userId);
            $beneficeAnnuel = $comptabiliteService->findBeneficeAnnuelByUser($userId);

            $user = $entityManager->getRepository(User::class)->find($userId);
            $salaire = $beneficeAnnuel * ($user->getPourcentageSalaireVerse() / 100);
            $chargesAnnuelles= $comptabiliteService->findChargesAnnuellesByUser($userId);

            return $this->render('comptabilite/bilan.html.twig', [
                    'remplacements' => $remplacementsAnneeEnCours,
                    'beneficeAnnuel' => $beneficeAnnuel,
                    'salaireAnnuel' => $salaire,
                    'form' => $form->createView(),
                    'chargesAnnuelles' => $chargesAnnuelles
                ]
            );
        }
    }

    #[Route('/comptabilite/charge/liste', name: 'app_comptabilite_charge_liste', methods: ['GET'])]
    public function afficherAjouterCharges(ChargesRepository $chargesRepository, Security $security): Response
    {
        $userId = $security->getUser()->getId();

        if (!$userId) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder aux données');
        }

        $charges = $chargesRepository->findChargesByUser($userId);

        return $this->render('charge/liste.html.twig', [
                'charges' => $charges,
            ]
        );
    }

    #[Route('/comptabilite/charge/create', name: 'app_comptabilite_charge_create', methods: ['GET', 'POST'])]
    public function ajouterCharge(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $userId = $security->getUser()->getId();

        if (!$userId) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder aux données');
        }

        $charge = new Charges();
        $charge->setUser($security->getUser());

       $form = $this->createForm(ChargesType::class, $charge);
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
           $entityManager ->persist($charge);
           $entityManager->flush();
           $this -> addFlash("success", 'charge ajoutée avec success');
           return $this->redirectToRoute('app_comptabilite_charge_liste', [], );
       }


        return $this->render('charge/create.html.twig', [
                'form' => $form->createView(),
            ]
        );
    }

    #[Route('/comptabilite/charge/delete/{id}', name: 'app_comptabilite_charge_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Charges $charge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$charge->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($charge);
            $entityManager->flush();
        }
        $this->addFlash("success", 'Charge supprimée avec succès');
        return $this->redirectToRoute('app_comptabilite_charge_liste', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/comptabilite/convertToXLS/{dateDebut}/{dateFin}', name: 'app_comptabilite_convert', methods: ['GET'])]
    public function convertToXLS($dateDebut, $dateFin, ComptabiliteService $comptabiliteService, Security $security): Response
    {
        $userId = $security->getUser()->getId();

        if (!$userId) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder aux données');
        }

        // Validation et conversion des dates
        if ($dateDebut && $dateFin) {
            try {
                $dateDebut = new \DateTime($dateDebut);
                $dateFin = new \DateTime($dateFin);
                $comptabiliteService->convertToXLS($userId, $dateDebut, $dateFin);
            } catch (\Exception $e) {
                return new Response('Les dates fournies ne sont pas valides.', Response::HTTP_BAD_REQUEST);
            }
        } else {
            return new Response('Les paramètres dateDebut et dateFin sont requis.', Response::HTTP_BAD_REQUEST);
        }

        // Appel du service pour générer le fichier Excel


        return $this->render('comptabilite/bilan.html.twig', [
            'message' => 'Le fichier Excel a été généré avec succès.'
        ]);
    }

}
