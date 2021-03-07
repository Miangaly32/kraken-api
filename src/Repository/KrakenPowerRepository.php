<?php

namespace App\Repository;

use App\Entity\KrakenPower;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KrakenPower|null find($id, $lockMode = null, $lockVersion = null)
 * @method KrakenPower|null findOneBy(array $criteria, array $orderBy = null)
 * @method KrakenPower[]    findAll()
 * @method KrakenPower[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KrakenPowerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KrakenPower::class);
    }

    // /**
    //  * @return KrakenPower[] Returns an array of KrakenPower objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KrakenPower
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
