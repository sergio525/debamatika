<?php

namespace App\Repository;

use App\Entity\VariableInforme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VariableInforme|null find($id, $lockMode = null, $lockVersion = null)
 * @method VariableInforme|null findOneBy(array $criteria, array $orderBy = null)
 * @method VariableInforme[]    findAll()
 * @method VariableInforme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VariableInformeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VariableInforme::class);
    }

    // /**
    //  * @return VariableInforme[] Returns an array of VariableInforme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VariableInforme
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
