<?php

namespace App\Repository;

use App\Entity\Utiente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Utiente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utiente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utiente[]    findAll()
 * @method Utiente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtienteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utiente::class);
    }

    // /**
    //  * @return Utiente[] Returns an array of Utiente objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Utiente
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
