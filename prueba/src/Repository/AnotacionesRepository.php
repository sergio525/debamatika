<?php

namespace App\Repository;

use App\Entity\Anotaciones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Anotaciones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anotaciones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anotaciones[]    findAll()
 * @method Anotaciones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnotacionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anotaciones::class);
    }

    // /**
    //  * @return Anotaciones[] Returns an array of Anotaciones objects
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
    public function findOneBySomeField($value): ?Anotaciones
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
