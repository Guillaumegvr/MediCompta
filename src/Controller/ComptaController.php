<?php

namespace App\Controller;

use App\Repository\RemplacementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ComptaController extends AbstractController
{
    #[Route('/comptabilite/edit', name: 'app_comptabilite_edit', methods: ['GET', 'POST'])]
    public function afficherRemplacementsEtAjouterCompta(RemplacementRepository $remplacementRepository): Response
    {
        $remplacements = $remplacementRepository->findRemplacementWithMedecin();
        return $this->render('comptabilite/edit.html.twig',  [
                'remplacements' => $remplacements,
            ]
        );
    }
}
