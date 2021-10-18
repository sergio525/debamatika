<?php

namespace App\Repository;

use App\Entity\Anotacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Anotacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anotacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anotacion[]    findAll()
 * @method Anotacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnotacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anotacion::class);
    }

    // /**
    //  * @return Anotacion[] Returns an array of Anotacion objects
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
    public function findOneBySomeField($value): ?Anotacion
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
