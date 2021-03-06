<?php

namespace App\Repository;

use App\Entity\Feuille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Feuille|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feuille|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feuille[]    findAll()
 * @method Feuille[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeuilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feuille::class);
    }

    public function findReponses1($manche)
    {
        return $this->createQueryBuilder('reponse_1')
            ->where('reponse_1.manche = :manche')
            ->setParameter('manche', $manche)
            ->getQuery()
            ->execute();
    }
    public function findReponses2($manche)
    {
        return $this->createQueryBuilder('reponse_2')
            ->where('reponse_1.manche = :manche')
            ->setParameter('manche', $manche)
            ->getQuery()
            ->execute();
    }

    // /**
    //  * @return Feuille[] Returns an array of Feuille objects
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
    public function findOneBySomeField($value): ?Feuille
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
