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

    public function findRemplacementWithMedecin():?array
    {
        $queryBuilder = $this->createQueryBuilder('r');
        $queryBuilder -> join("r.medecin", 'm')
            -> addSelect ('m');
        $queryBuilder -> orderBy('r.dateCreation', 'DESC');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function findRemplacementsAvecSommesDesc(): ?array
    {
        $queryBuilder = $this->createQueryBuilder('r');

        // Joindre la table 'medecin' pour récupérer les données du médecin
        $queryBuilder->join('r.medecin', 'm')
            ->addSelect('m');

        // Ajouter la condition pour filtrer les remplacements avec paiementEffectué > 0
        $queryBuilder->where('r.paiementEffectue IS NULL OR r.paiementEffectue <= 0');

        // Trier les résultats par ordre décroissant
        $queryBuilder->orderBy('r.dateCreation', 'DESC');

        // Exécuter la requête et retourner les résultats
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    public function findRetrocession(): ?array
    {
        $queryBuilder = $this->createQueryBuilder('r');

        // Joindre la table 'medecin' pour récupérer les données du médecin
        $queryBuilder->join('r.medecin', 'm')
            ->addSelect('m');

        // Ajouter la condition pour filtrer les remplacements avec paiementEffectué > 0
        $queryBuilder->where('r.paiementEffectue IS NULL OR r.paiementEffectue <= 0');

        // Trier les résultats par ordre décroissant
        $queryBuilder->orderBy('r.dateCreation', 'DESC');

        // Exécuter la requête et retourner les résultats
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }
    //    /**
    //     * @return Remplacement[] Returns an array of Remplacement objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Remplacement
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
