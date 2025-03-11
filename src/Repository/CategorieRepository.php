<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    /**
     * @return Categorie[]
     */
    public function getCategoriesAvecStagesNonExpires()
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->innerJoin('c.stages', 's')
            ->where('s.date_expiration > :date')
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne les stages non expirés pour une catégorie donnée
     * 
     * @param Categorie $categorie
     * @return Stage[]
     */
    public function getStagesNonExpires(Categorie $categorie)
    {
        return $this->createQueryBuilder('c')
            ->select('s')
            ->join('c.stages', 's')
            ->where('c.id = :categorieId')
            ->andWhere('s.date_expiration > :date')
            ->setParameter('categorieId', $categorie->getId())
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getResult();
    }
}
