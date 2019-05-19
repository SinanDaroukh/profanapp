<?php

namespace App\Repository;

use App\Entity\Medium;
use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Medium|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medium|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medium[]    findAll()
 * @method Medium[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediumRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Medium::class);
    }

    public function findAllQuery(Search $search) : Query
    {
        $query = $this->createQueryBuilder('m');

        if ( $search->getNom()){
            $query = $query
                ->andWhere('m.nom LIKE \'%' . $search->getNom() . '%\'');
        }

        if ( $search->getLocalisation()){
            $query = $query
                ->andWhere('m.localisation = :localisation')
                ->setParameter('localisation', $search->getLocalisation());
        }
        if ( $search->getType()){
            $query = $query
                ->andWhere('m.type = :type')
                ->setParameter('type', $search->getType());
        }
        if ( $search->getCodebarre()){
            $query = $query
                ->andWhere('m.codebarre = :codebarre')
                ->setParameter('codebarre', $search->getCodebarre());
        }
        if ( $search->getQuantitymax()){
        $query = $query
            ->andWhere('m.quantity < :quantity')
            ->setParameter('quantity', $search->getQuantitymax());
    }


        return $query->getQuery();
    }


    // /**
    //  * @return Medium[] Returns an array of Medium objects
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
    public function findOneBySomeField($value): ?Medium
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
