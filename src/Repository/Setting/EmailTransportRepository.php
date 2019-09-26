<?php

namespace Hubsine\SkeletonBundle\Repository\Setting;

use Hubsine\SkeletonBundle\Entity\Setting\EmailTransport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EmailTransport|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailTransport|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailTransport[]    findAll()
 * @method EmailTransport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailTransportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailTransport::class);
    }
}
