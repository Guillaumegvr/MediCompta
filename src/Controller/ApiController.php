<?php

namespace App\Controller;

use App\Entity\Remplacement;
use App\Repository\MedecinRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/calendar/api/{id}/edit', name: 'api_event_edit', methods: ['POST'])]
    public function majEvent(Request $request, ?Remplacement $remplacement, Security $security, UserRepository $userRepository, MedecinRepository $medecinRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $donnee = json_decode($request->getContent(), true);

        if (
            isset($donnee['title']) && !empty($donnee['title']) &&
            isset($donnee['start']) && !empty($donnee['start']) &&
            isset($donnee['end']) && !empty($donnee['end'])
        ) {
            $code = 200;

            if (!$remplacement) {
                $remplacement = new Remplacement();
                $code = 201; // Création d'une nouvelle ressource
            }

            $userId = $security->getUser()->getId();

            if (!$userId) {
                return new JsonResponse(['error' => 'Vous devez être connecté pour créer un remplacement.'], 403);
            }

            $user = $userRepository->find($userId);
            if (!$user) {
                return new JsonResponse(['error' => 'Utilisateur non trouvé.'], 403);
            }

            $remplacement->setUser($user);

            $medecin = $medecinRepository->find($donnee['title']); // Assurez-vous que 'title' est bien l'ID du médecin
            if (!$medecin) {
                return new JsonResponse(['error' => 'Médecin non trouvé.'], 404);
            }

            $remplacement->setMedecin($medecin);

            $beginAt = DateTime::createFromFormat(DateTime::ISO8601, $donnee['start']);
            $endAt = DateTime::createFromFormat(DateTime::ISO8601, $donnee['end']);

            if ($beginAt === false || $endAt === false) {
                return new JsonResponse(['error' => 'Format de date invalide'], 400);
            }

            $remplacement->setBeginAt($beginAt);
            $remplacement->setEndAt($endAt);
            $remplacement->setDateCreation(new DateTime());

            $entityManager->persist($remplacement);
            $entityManager->flush();

            return new JsonResponse(['success' => 'Remplacement enregistré avec succès.'], $code);
        } else {
            return new JsonResponse(['error' => 'Données incomplètes'], 400);
        }
    }
}
