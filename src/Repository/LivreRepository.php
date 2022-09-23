<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }


    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */

    //action 13
    public function findByDate_parution($Value1,$Value2)
    {
        return $this->createQueryBuilder('l')
            ->Where('l.dateParution >= :val')
            ->setParameter('val', date($Value1))
            ->andWhere('l.dateParution <= :val2')
            ->setParameter('val2', date($Value2))
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByOneTitre($Value1)
    {
        return $this->createQueryBuilder('l')
        ->Where('l.titre LIKE :val')
        ->setParameter('val','%'.$Value1.'%')
        ->getQuery()
        ->getResult()
    ;
    }

    //action 15
    public function findByDate_parutionAndNote($datedebut, $datefin, $notemin, $notemax)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.dateParution > :val')
            ->setParameter('val', date($datedebut))
            ->andWhere('l.dateParution < :val2')
            ->setParameter('val2', date($datefin))
            ->andWhere('l.note > :val3')
            ->setParameter('val3', $notemin)
            ->andWhere('l.note < :val4')
            ->setParameter('val4', $notemax)
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
     
     // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */

    
    
    
}
