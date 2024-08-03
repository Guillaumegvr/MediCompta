<?php

namespace App\Controller;

use App\Service\ComptabiliteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TableauDeBordController extends AbstractController
{
    #[Route('/tableau-de-bord', name: 'app_main_tableauDeBord')]
    public function affichercomptabiliteBilan(ComptabiliteService $comptabiliteService, Security $security): Response
    {
        $userId = $security->getUser()->getId();

        if (!$userId) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder aux données');
        }

        $beneficeAnnuel = $comptabiliteService ->findBeneficeAnnuelByUser($userId);
        $beneficeMensuel= $comptabiliteService ->findBeneficesMensuelByUser($userId);
        $paiementEnAttente = $comptabiliteService -> findEnAttenteDeRetrocessionByUser($userId);
        $remplacementsDuMois = $comptabiliteService->findRemplacementMoisByUser($userId);

        $pourcentageMicroBNC = 100 * ($beneficeAnnuel / 77000);


        return $this->render('tableau_de_bord/tableauDeBord.html.twig',  [
                'beneficeAnnuel' => $beneficeAnnuel,
                'beneficeMensuel' => $beneficeMensuel,
                'paiementEnAttente' => $paiementEnAttente,
                'pourcentageMicroBNC' => $pourcentageMicroBNC,
                'remplacementsDuMois' => $remplacementsDuMois
            ]
        );
    }
}
