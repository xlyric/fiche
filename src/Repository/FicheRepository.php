<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Fiche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fiche>
 *
 * @method Fiche|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fiche|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fiche[]    findAll()
 * @method Fiche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fiche::class);
    }

    public function recherche($value)
    {
        return $this->createQueryBuilder('c')
            ->Where('c.titre LIKE :val')
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(15)
            ->getQuery()
            ->getResult()
        ;
    }



    public function add(Fiche $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fiche $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


     /**
     * retourner les requetes de recherche article/categorie
     * @return Fiche[]
     */
    public function findwithSearch (Search $search)
    {
        $query = $this
        ->createQueryBuilder('p')
        ->select('c','p')
        ->join('p.categorie','c');

        if (!empty($search->categories)){
            $query = $query
            ->andWhere('c.id IN (:categories)') 
            ->setParameter('categories',$search->categories);
        }

        if (!empty($search->string)){
            $query = $query
            ->andWhere('p.titre LIKE :string')
            ->setParameter('string',"%{$search->string}%");
        }


        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Fiche[] Returns an array of Fiche objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Fiche
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
