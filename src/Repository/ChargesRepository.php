<?php

namespace App\Repository;

use App\Entity\Charges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Charges>
 */
class ChargesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Charges::class);
    }

    public function findChargesByUser($idUser): ?array
    {
        $queryBuilder = $this->createQueryBuilder('c');

        // Joindre la relation 'charges' de l'utilisateur
        $queryBuilder->join('c.user', 'u');

        // Sélectionner les charges
        $queryBuilder->select('c');

        // Filtrer par l'utilisateur
        $queryBuilder->where('u.id = :idUser');
        $queryBuilder->setParameter('idUser', $idUser);

        // Ordonner par date de création décroissante
        $queryBuilder->orderBy('c.dateCreation', 'DESC');

        // Exécuter la requête
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function findByDatesAndUser($idUser, \DateTime $dateDebut, \DateTime $dateFin): ?array
    {
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder->join('c.user', 'u');
        $queryBuilder->select('c');
        $queryBuilder->where('u.id = :idUser')
            ->setParameter('idUser', $idUser);
        $queryBuilder->andWhere('c.dateCreation BETWEEN :dateDebut AND :dateFin')
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin);
        $queryBuilder->orderBy('c.dateCreation', 'DESC');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

}
