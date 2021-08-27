<?php

namespace App\Repository;

use App\Entity\CourrierArchive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CourrierArchive|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourrierArchive|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourrierArchive[]    findAll()
 * @method CourrierArchive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourrierArchiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourrierArchive::class);
    }

    // /**
    //  * @return CourrierArchive[] Returns an array of CourrierArchive objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CourrierArchive
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
