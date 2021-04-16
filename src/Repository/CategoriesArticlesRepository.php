<?php

namespace App\Repository;

use App\Entity\CategoriesArticles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoriesArticles|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoriesArticles|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoriesArticles[]    findAll()
 * @method CategoriesArticles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoriesArticles::class);
    }

    // /**
    //  * @return CategoriesArticles[] Returns an array of CategoriesArticles objects
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
    public function findOneBySomeField($value): ?CategoriesArticles
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
