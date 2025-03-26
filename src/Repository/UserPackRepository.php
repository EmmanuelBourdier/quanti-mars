<?php

namespace App\Repository;

use App\Entity\UserPack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserPack>
 */
class UserPackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPack::class);
    }

    public function findOneByCredit($userId): ?UserPack
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.user = :val')
            ->andWhere('u.credit > 0')
            ->setParameter('val', $userId)
            ->getQuery()
            ->getOneOrNullResult()
       ;
   }
}
