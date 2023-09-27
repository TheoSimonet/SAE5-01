<?php

namespace App\Repository;

use App\Entity\PeriodType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PeriodType>
 *
 * @method PeriodType|null find($id, $lockMode = null, $lockVersion = null)
 * @method PeriodType|null findOneBy(array $criteria, array $orderBy = null)
 * @method PeriodType[]    findAll()
 * @method PeriodType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeriodTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PeriodType::class);
    }

//    /**
//     * @return PeriodType[] Returns an array of PeriodType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PeriodType
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
