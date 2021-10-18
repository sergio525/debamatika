<?php

namespace App\Repository\Admin;

use App\Entity\Admin\tipoBloque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method tipoBloque|null find($id, $lockMode = null, $lockVersion = null)
 * @method tipoBloque|null findOneBy(array $criteria, array $orderBy = null)
 * @method tipoBloque[]    findAll()
 * @method tipoBloque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class tipoBloqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, tipoBloque::class);
    }

    // /**
    //  * @return tipoBloque[] Returns an array of tipoBloque objects
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
    public function findOneBySomeField($value): ?tipoBloque
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
