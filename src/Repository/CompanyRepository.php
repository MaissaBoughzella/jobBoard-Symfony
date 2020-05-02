<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Job;
use App\Entity\Category;
use App\Entity\Company;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Company::class);
        $this->paginator=$paginator;
    }

    // /**
    //  * @return Company[] Returns an array of Company objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Company
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findC()
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSearch(SearchData $search): PaginationInterface
    {
       
        $query=$this->createQueryBuilder('c')
        ->select('c')
        ->leftJoin('c.category', 'cat');
        if(!empty($search->q))
        { 
            $query=$query
            ->andWhere('c.name LIKE :q')
            ->setParameter('q',"%{$search->q}%")
            ->setMaxResults(10);
        }

        if(!empty($search->l))
        { 
            $query=$query
            ->andWhere('c.location LIKE :l')
            ->setParameter('l',"%{$search->l}%")
            ->setMaxResults(10);
        }

        if(!empty($search->categories)){
            $query=$query
            ->andwhere('cat.id IN (:categories)')
            ->setParameter('categories',$search->categories);
        }

        $query=$query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            2
        );
    }
    
}
