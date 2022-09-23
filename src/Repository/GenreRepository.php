<?php

namespace App\Repository;

use App\Entity\Genre;
use App\Entity\GenreSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Genre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Genre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Genre[]    findAll()
 * @method Genre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Genre::class);
    }

    // /**
    //  * @return Genre[] Returns an array of Genre objects
    //  */
   
    public function findTwoByAuteur($auteurId)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.livre', 'l') 
            ->innerJoin('l.auteur', 'a')
            ->where('a.id = :auteurId')
            ->groupBy('g')
            ->having('COUNT(g.id) >= 2')
            ->setParameter('auteurId', $auteurId)
            ->getQuery()
            ->getResult();
    }

    public function findByAuteur($auteurId,$livreId)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.livreGenre', 'l')
            ->innerJoin('l.livreAuteur', 'a')
            ->where('l.id = :livreId')
            ->setParameter('livreId', $livreId)
            ->andWhere('a.id = :auteurId')
            ->setParameter('auteurId', $auteurId)
            ->select('g.nom')
            ->distinct()
            ->getQuery()
            ->getResult();
    }
}
