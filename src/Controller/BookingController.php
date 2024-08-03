<?php

namespace App\Controller;

use App\Entity\Remplacement;
use App\Form\RemplacementType;
use App\Repository\RemplacementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class BookingController extends AbstractController
{
    #[Route(path: '/calendar', name: 'app_booking_calendar', methods: ['GET'])]
    public function calendar(RemplacementRepository $remplacementRepository): Response
    {
        $events = $remplacementRepository->findAll();

        $remplacements = [];
        foreach ($events as $event) {
            $remplacements[] = [
                'id' => $event->getId(),
                'title' => $event->getMedecin()->getNom(),
                'start' => $event->getDateDebut()->format('Y-m-d H:i:s'),
                'end' => $event->getDateFin()->format('Y-m-d H:i:s'),
            ];
        }
        $data=json_encode($remplacements);
        return $this->render('booking/calendar.html.twig', compact('data'));
    }



}
