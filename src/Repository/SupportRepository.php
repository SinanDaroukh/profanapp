<?php

namespace App\Repository;

use App\Entity\Support;
use App\Entity\SupportSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Support|null find($id, $lockMode = null, $lockVersion = null)
 * @method Support|null findOneBy(array $criteria, array $orderBy = null)
 * @method Support[]    findAll()
 * @method Support[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Support::class);
    }

    public function findAllQuery(SupportSearch $search) : Query
    {
        $query = $this->createQueryBuilder('s');

        if ( $search->getBarcode()){
            $query = $query
                        ->andWhere('s.barcode = :barcode')
                        ->setParameter('barcode', $search->getBarcode());
        }
        if ( $search->getName()){
            $query = $query
                ->andWhere('s.name LIKE \'%' . $search->getName() . '%\'');
        }
        if ( $search->getType()){
            $query = $query
                ->andWhere('s.type = :type')
                ->setParameter('type', $search->getType());
        }
        if ( $search->getGrammage()){
            $query = $query
                ->andWhere('s.grammage = :grammage')
                ->setParameter('grammage', $search->getGrammage());
        }
        if ( $search->getQuantity()){
            $query = $query
                ->andWhere('s.quantity < :x')
                ->setParameter('x', $search->getQuantity());
        }
        if ( $search->getLocalisation()){
        $query = $query
            ->andWhere('s.localisation = :localisation')
            ->setParameter('localisation', $search->getLocalisation());
    }

        return $query->getQuery();
    }

    // /**
    //  * @return Support[] Returns an array of Support objects
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
    public function findOneBySomeField($value): ?Support
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
