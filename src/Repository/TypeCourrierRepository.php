<?php

namespace App\Repository;

use App\Entity\TypeCourrier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TypeCourrier|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeCourrier|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeCourrier[]    findAll()
 * @method TypeCourrier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeCourrierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeCourrier::class);
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
