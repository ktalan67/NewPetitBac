<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @param $theme
     * @param $number
     * @return int|mixed|string
     */
    public function findRandomQuestionsByTheme($theme, $number)
    {
        //Ajout composer require beberlei/doctrineextensions + modif doctrine.yaml -> utiliser fonction RAND()
        return $this->createQueryBuilder('q')
            ->where('q.theme = :theme')
            ->setParameter('theme', $theme)
            ->setMaxResults($number)
            ->orderBy('RAND()')
            ->getQuery()
            ->getResult();


        //Méthode "hack"
//        $order = array_rand(array(
//            'DESC' => 'DESC',
//            'ASC' => 'ASC',
//            'DESC' => 'DESC'
//        ));
//
//        $column = array_rand(array(
//            'q.title' => 'q.title',
//            'q.id' => 'q.id',
//            'q.created_at' => 'q.created_at',
//        ));
    }

    // /**
    //  * @return Question[] Returns an array of Question objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Question
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
