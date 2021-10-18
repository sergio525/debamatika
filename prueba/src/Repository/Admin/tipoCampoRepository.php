<?php

namespace App\Repository\Admin;

use App\Entity\Admin\tipoCampo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method tipoCampo|null find($id, $lockMode = null, $lockVersion = null)
 * @method tipoCampo|null findOneBy(array $criteria, array $orderBy = null)
 * @method tipoCampo[]    findAll()
 * @method tipoCampo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class tipoCampoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, tipoCampo::class);
    }

    // /**
    //  * @return tipoCampo[] Returns an array of tipoCampo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?tipoCampo
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
