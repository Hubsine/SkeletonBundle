<?php

namespace Hubsine\SkeletonBundle\Repository\Setting;

use Hubsine\SkeletonBundle\Entity\Setting\MaintenanceTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MaintenanceTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaintenanceTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaintenanceTranslation[]    findAll()
 * @method MaintenanceTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaintenanceTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaintenanceTranslation::class);
    }
    
    public function findOneByEnabled(bool $enable)
    {
        return $this->createQueryBuilder('m')
                ->select('m, t')
                ->join('m.translatable', 't')
                ->andWhere('t.enable = :enable')
                ->setParameter('enable', $enable)
                ->getQuery()
                ->getOneOrNullResult();
    }

    // /**
    //  * @return Maintenance[] Returns an array of Maintenance objects
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
    public function findOneBySomeField($value): ?Maintenance
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
