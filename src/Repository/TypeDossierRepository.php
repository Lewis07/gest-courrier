<?php

namespace App\Repository;

use App\Entity\TypeDossier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeDossier|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeDossier|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeDossier[]    findAll()
 * @method TypeDossier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeDossierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeDossier::class);
    }

    // /**
    //  * @return TypeDossier[] Returns an array of TypeDossier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeDossier
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
