<?php

namespace App\Repository;

use App\Entity\EquipoInstalado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EquipoInstalado|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipoInstalado|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipoInstalado[]    findAll()
 * @method EquipoInstalado[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipoInstaladoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipoInstalado::class);
    }

    // /**
    //  * @return EquipoInstalado[] Returns an array of EquipoInstalado objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EquipoInstalado
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
