<?php

namespace App\Repository;

use App\Entity\Remplacement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Remplacement>
 */
class RemplacementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Remplacement::class);
    }

    public function findRemplacementsWithMedecinByUser($idUser): ?array
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder->join('r.medecin', 'm');
        $queryBuilder->where('r.user = :User_id')
            ->setParameter('User_id', $idUser);
        $queryBuilder->orderBy('r.dateCreation', 'DESC');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function findRemplacementsNonPayesAvecSommesDescByUSer($idUser): ?array
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder->join('r.medecin', 'm');
        $queryBuilder->where('r.retrocession IS NULL OR r.retrocession <= 0');
        $queryBuilder->andWhere('r.user = :User_id')
            ->setParameter('User_id', $idUser);
        $queryBuilder->orderBy('r.dateCreation', 'DESC');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function findRetrocessionsByDatesAndUser($idUser, \DateTime $dateDebut, \DateTime $dateFin): ?array
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder->Select('r.retrocession');
        $queryBuilder->join('r.user', 'u');
        $queryBuilder->where('r.retrocession IS NOT NULL');
        $queryBuilder->andWhere('u.id = :idUser')
            ->setParameter('idUser', $idUser);
        $queryBuilder->andWhere('r.datePaiement BETWEEN :dateDebut AND :dateFin')
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin);
        $queryBuilder->orderBy('r.datePaiement', 'DESC');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function findByDatesAndUser($idUser, \DateTime $dateDebut, \DateTime $dateFin): ?array
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder->join('r.user', 'u');
        $queryBuilder->join('r.medecin', 'm');
        $queryBuilder->select('r');
        $queryBuilder->where('u.id = :idUser')
            ->setParameter('idUser', $idUser);
        $queryBuilder->andWhere('r.dateDebut BETWEEN :dateDebut AND :dateFin')
            ->setParameter('dateDebut', $dateDebut)
            ->setParameter('dateFin', $dateFin);
        $queryBuilder->orderBy('r.dateFin', 'DESC');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function findEnAttenteRetrocessionByUser($idUser): ?array
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder->Select('r.chiffreRealiseParRemplacement');
        $queryBuilder->join('r.user', 'u');
        $queryBuilder->where('r.retrocession IS NULL');
        $queryBuilder->andWhere('u.id = :idUser')
            ->setParameter('idUser', $idUser);
        $queryBuilder->orderBy('r.dateCreation', 'DESC');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }


}
