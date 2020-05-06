<?php

namespace App\Repository;

use App\Entity\ModeleChaussure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModeleChaussure|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModeleChaussure|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModeleChaussure[]    findAll()
 * @method ModeleChaussure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModeleChaussureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModeleChaussure::class);
    }

    // /**
    //  * @return ModeleChaussure[] Returns an array of ModeleChaussure objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModeleChaussure
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
