<?php

namespace App\Repository;

use App\Entity\Club;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Club|null find($id, $lockMode = null, $lockVersion = null)
 * @method Club|null findOneBy(array $criteria, array $orderBy = null)
 * @method Club[]    findAll()
 * @method Club[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Club::class);
    }
    //-------question 4 + 5--------
    public function findClubOrderByDate(){
       return $this->createQueryBuilder('club')
           ->where("club.enable = :enable")
           ->setParameter("enable","1")
            ->orderBy("club.creation_date","ASC")
           ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

}
