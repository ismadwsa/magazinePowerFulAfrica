<?php

namespace App\Repository;

use App\Entity\AncienMagazine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AncienMagazine|null find($id, $lockMode = null, $lockVersion = null)
 * @method AncienMagazine|null findOneBy(array $criteria, array $orderBy = null)
 * @method AncienMagazine[]    findAll()
 * @method AncienMagazine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AncienMagazineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AncienMagazine::class);
    }

    // /**
    //  * @return AncienMagazine[] Returns an array of AncienMagazine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AncienMagazine
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
