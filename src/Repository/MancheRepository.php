<?php

namespace App\Repository;

use App\Entity\Manche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Manche|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manche|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manche[]    findAll()
 * @method Manche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MancheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manche::class);
    }

    // /**
    //  * @return Manche[] Returns an array of Manche objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Manche
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
