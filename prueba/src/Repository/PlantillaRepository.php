<?php

namespace App\Repository;

use App\Entity\Plantilla;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Plantilla|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plantilla|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plantilla[]    findAll()
 * @method Plantilla[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlantillaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plantilla::class);
    }

    // /**
    //  * @return Plantilla[] Returns an array of Plantilla objects
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
    public function findOneBySomeField($value): ?Plantilla
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
