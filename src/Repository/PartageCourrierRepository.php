<?php

namespace App\Repository;

use App\Entity\PartageCourrier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PartageCourrier|null find($id, $lockMode = null, $lockVersion = null)
 * @method PartageCourrier|null findOneBy(array $criteria, array $orderBy = null)
 * @method PartageCourrier[]    findAll()
 * @method PartageCourrier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartageCourrierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PartageCourrier::class);
    }

    /* liste partage de courrier */
    public function partageCourrierUtilisateur($user_id)
    {
        return $this->createQueryBuilder('p')
            ->addSelect('p','r')
            ->leftJoin('p.sharer','r')
            ->andWhere('p.id = :user_id')
            ->setParameter('user_id', $user_id)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return PartageCourrier[] Returns an array of PartageCourrier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PartageCourrier
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
