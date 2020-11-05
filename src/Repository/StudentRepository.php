<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }
    public function findStudentOrderByNsc(){
        return $this->createQueryBuilder('student')
            ->orderBy("student.NSC","ASC")
            ->getQuery()
            ->getResult();
    }
    //------question 3
    public function findStudentOrderByClassroom(){
        return $this->createQueryBuilder('student')
            ->orderBy("student.classroom","ASC")
            ->getQuery()
            ->getResult();
    }
//----------question 1+2-----------------
    public function searchStudentByNSC($NSC){
        return $this->createQueryBuilder('student')
            ->where("student.NSC LIKE :NSC")
            ->setParameter("NSC","%".$NSC."%")
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Student[] Returns an array of Student objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Student
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
