<?php

namespace App\Repository;

use App\Entity\PubliciteHeader;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PubliciteHeader|null find($id, $lockMode = null, $lockVersion = null)
 * @method PubliciteHeader|null findOneBy(array $criteria, array $orderBy = null)
 * @method PubliciteHeader[]    findAll()
 * @method PubliciteHeader[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PubliciteHeaderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PubliciteHeader::class);
    }

    // /**
    //  * @return PubliciteHeader[] Returns an array of PubliciteHeader objects
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
    public function findOneBySomeField($value): ?PubliciteHeader
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
