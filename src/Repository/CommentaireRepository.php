<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaire>
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

       /**
        * @return Commentaire[] Returns an array of Commentaire objects
        */
       public function findByVerified(): array
        {
          return $this->createQueryBuilder('c')
               ->andWhere('c.verified = :val')
               ->setParameter('val', "oui")
                ->orderBy('c.createAt', 'DESC')
                ->getQuery()
               ->getResult()
         ;
       }

       public function findRandomVerifiedComments()
    {
      $comments = $this->createQueryBuilder('c')
      ->where('c.verified = :verified')
      ->setParameter('verified', 'oui')
      ->orderBy('c.createAt', 'DESC')
      ->getQuery()
      ->getResult();

  // Shuffle the array to randomize the order
  shuffle($comments);

  // Return the first three comments
  return array_slice($comments, 0, 3);
    }

    //    public function findOneBySomeField($value): ?Commentaire
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
