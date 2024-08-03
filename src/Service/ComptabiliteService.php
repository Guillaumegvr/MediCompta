<?php

namespace App\Service;

use App\Repository\ChargesRepository;
use App\Repository\RemplacementRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ComptabiliteService
{
    private $remplacementRepository;
    private $chargesRepository;

    public function __construct(RemplacementRepository $remplacementRepository, ChargesRepository $chargesRepository)
    {
        $this->remplacementRepository = $remplacementRepository;
        $this->chargesRepository = $chargesRepository;
    }

    public function findBeneficeAnnuelByUser($idUser)
    {
        $premierJourAnneeEnCours = new \DateTime('first day of January this year');
        $dateDuJour = new \DateTime('now');

        $ensembleDesPaiements = $this->remplacementRepository->findRetrocessionsByDatesAndUser($idUser, $premierJourAnneeEnCours, $dateDuJour);

        if (empty($ensembleDesPaiements)) {
            return 0;
        }
        $montants = array_map(function ($paiement) {
            return $paiement['retrocession'];
        }, $ensembleDesPaiements);

        return array_sum($montants);
    }

    public function findRemplacementAnneeEnCoursByUser($idUser): ?array
    {
        $premierJourAnneeEnCours = new \DateTime('first day of January this year');
        $dateDuJour = new \DateTime('now');

        return $this->remplacementRepository->findByDatesAndUser($idUser, $premierJourAnneeEnCours, $dateDuJour);
    }

    public function findRemplacementMoisByUser($idUser)
    {
        $premierJourAnneeEnCours = new \DateTime('now');
        $dateDuJour = new \DateTime('last day of this month');

        return $this->remplacementRepository->findByDatesAndUser($idUser, $premierJourAnneeEnCours, $dateDuJour);
    }

    public function findBeneficesMensuelByUser($idUser)
    {
        $DateDuJourMoinsUnMois = new \DateTime('first day of this month');
        $dateDuJour = new \DateTime('now');

        $ensembleDesPaiements = $this->remplacementRepository->findRetrocessionsByDatesAndUser($idUser, $DateDuJourMoinsUnMois, $dateDuJour);

        $montants = array_map(function ($paiement) {
            return $paiement['retrocession']; //
        }, $ensembleDesPaiements);

        return array_sum($montants);
    }

    public function findEnAttenteDeRetrocessionByUser($idUser): float|int
    {
        $paiementsEnAttente = $this->remplacementRepository->findEnAttenteRetrocessionByUser($idUser);

        $montants = array_map(function ($paiement) {
            return $paiement['chiffreRealiseParRemplacement'];
        }, $paiementsEnAttente);

        return array_sum($montants);
    }

    public function findByDatesAndUser($idUser, $dateDebut, $dateFin)
    {
        return $this->remplacementRepository->findByDatesAndUser($idUser, $dateDebut, $dateFin);
    }

    public function findAllByUser($idUser)
    {
        return $this->remplacementRepository->findRemplacementsWithMedecinByUser($idUser);
    }

    public function finChargesByDatesAndUser($idUser, $dateDebut, $dateFin)
    {
        $charges = $this->chargesRepository->findByDatesAndUser($idUser, $dateDebut, $dateFin);

        $montants = array_map(function ($paiement) {
            return $paiement->getMontant();
        }, $charges);

        return array_sum($montants);
    }

    public function findChargesAnnuellesByUser($idUser)
    {
        $DateDuJourMoinsUnMois = new \DateTime('first day of January this year');
        $dateDuJour = new \DateTime('now');

        $ensembleDesCharges = $this->chargesRepository->findByDatesAndUser($idUser, $DateDuJourMoinsUnMois, $dateDuJour);

        if (empty($ensembleDesCharges)) {
            return 0;
        }

        $montants = array_map(function ($paiement) {
            return $paiement->getMontant();
        }, $ensembleDesCharges);

        return array_sum($montants);
    }


    public function convertToXLS($userId, \DateTime $dateDebut, \DateTime $dateFin)
    {
        $remplacements_data = $this->remplacementRepository->findByDatesAndUser($userId, $dateDebut, $dateFin);

        // Création du document Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // En-têtes des colonnes
        $headers = ['ID', 'Médecin remplacé', 'Date début', 'Date fin', 'Chiffre Realisé', 'Retrocession', 'Date de paiement', 'Salaire versé'];
        $sheet->fromArray($headers, null, 'A1');

        // Remplissage des données
        $rowIndex = 2; // Commence à la ligne 2 pour les données, après les en-têtes
        foreach ($remplacements_data as $remplacement) {
            $sheet->setCellValue('A' . $rowIndex, $remplacement->getMedecin()->getNom() . ' ' . $remplacement->getMedecin()->getPrenom());
            $sheet->setCellValue('B' . $rowIndex, $remplacement->getBeginAt()->format('Y-m-d'));
            $sheet->setCellValue('C' . $rowIndex, $remplacement->getEndAt()->format('Y-m-d'));
            $sheet->setCellValue('D' . $rowIndex, $remplacement->getChiffreRealise());
            $sheet->setCellValue('E' . $rowIndex, $remplacement->getPaiementEffectue());
            $sheet->setCellValue('F' . $rowIndex, $remplacement->getDateDePaiement() ? $remplacement->getDateDePaiement()->format('Y-m-d') : '');
            $sheet->setCellValue('G' . $rowIndex, $remplacement->getSalaireVerse() ?? '');
            $rowIndex++;
        }


        $writer = new Xlsx($spreadsheet);
        $fileName = 'remplacements du_' . $dateDebut->format('Ymd') . '_au_' . $dateFin->format('Ymd') . '.xlsx';


        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }


}