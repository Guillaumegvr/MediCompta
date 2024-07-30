<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TableauDeBordController extends AbstractController
{
    #[Route('/tableau-de-bord', name: 'app_main_tableauDeBord')]
    public function home(): Response
    {
        if ($this->getUser()) {
            $userName = $this->getUser()->getPrenom();
            return $this->render('tableau_de_bord/tableauDeBord.html.twig',
                ['userName' => $userName]);
        }

        return $this->render('tableau_de_bord/tableauDeBord.html.twig');
    }
}
