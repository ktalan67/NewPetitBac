<?php

namespace App\Repository;

use App\Entity\ResultatManche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ResultatManche|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResultatManche|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResultatManche[]    findAll()
 * @method ResultatManche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultatMancheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResultatManche::class);
    }

    // /**
    //  * @return ResultatManche[] Returns an array of ResultatManche objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResultatManche
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
