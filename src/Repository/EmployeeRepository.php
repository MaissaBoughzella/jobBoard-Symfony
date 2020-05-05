<?php

namespace App\Repository;
use App\Data\SearchData;
use App\Entity\Job;
use App\Entity\Category;
use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Employee::class);
        $this->paginator=$paginator;
    }

    // /**
    //  * @return Employee[] Returns an array of Employee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Employee
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findE()
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->orderBy('e.created_at', 'DESC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult()
        ;
    }

     /**
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search ): PaginationInterface
    {
       
        $query=$this->createQueryBuilder('e')
        ->select('e')
        ->orderBy('e.created_at', 'DESC')
        ->leftJoin('e.category', 'c')
        ->leftJoin('e.type', 't');
        if(!empty($search->q))
        { 
            $query=$query
            ->andWhere('e.prof LIKE :q')
            ->setParameter('q',"%{$search->q}%")
            ->orderBy('e.created_at', 'DESC');
            
        }

        if(!empty($search->min))
        { 
            $query=$query
            ->andWhere('e.salary >= :min')
            ->setParameter('min',$search->min)
            ->orderBy('e.created_at', 'DESC');
            
        }

        if(!empty($search->max))
        { 
            $query=$query
            ->andWhere('e.salary <= :max')
            ->setParameter('max',$search->max)
            ->orderBy('e.created_at', 'DESC');
            
        }

        if(!empty($search->categories)){
            $query=$query
            ->andwhere('c.id IN (:categories)')
            ->setParameter('categories',$search->categories);
        }

        if(!empty($search->types)){
            $query=$query
            ->andwhere('t.id IN (:types)')
            ->setParameter('types',$search->types);
        }
        $query=$query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            1
        );
    }
}
