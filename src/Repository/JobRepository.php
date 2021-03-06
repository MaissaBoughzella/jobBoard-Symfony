<?php

namespace App\Repository;
use App\Data\SearchData;
use App\Entity\Job;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Job::class);
        $this->paginator=$paginator;
    }

    // /**
    //  * @return Job[] Returns an array of Job objects
    //  */
    //find jobs by category
    public function findByCat($value)
    {
        return $this->createQueryBuilder('j')
            ->select('j')
            ->leftJoin('j.category', 'c')
            ->andWhere('j.category = :val')
            ->setParameter('val', $value)
            ->orderBy('j.createdAt', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }
    //to  get only 8 jobs
    public function findJ()
    {
        return $this->createQueryBuilder('j')
            ->select('j')
            ->orderBy('j.createdAt', 'DESC')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult()
        ;
    }
    

    
    // public function findOneById($id): ?Job
    // {
    //     return $this->createQueryBuilder('j')
    //         ->andWhere('j.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
    
    // findSearch to filter jobs by key word or/and category or/and type job
    /**
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
       
        $query=$this->createQueryBuilder('j')
        ->select('j')
        ->orderBy('j.createdAt', 'DESC')
        ->leftJoin('j.category', 'c')
        ->leftJoin('j.type', 't');
        if(!empty($search->q))
        { 
            $query=$query
            ->andWhere('j.name LIKE :q')
            ->setParameter('q',"%{$search->q}%")
            ->orderBy('j.createdAt', 'DESC')
            ->setMaxResults(10);
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
            2
        );
    }
    //get the jobs offer of comapny and filter by key word or/and category or/and type job
    /**
     * @return PaginationInterface
     */
    public function findSearch1(SearchData $search , $id): PaginationInterface
    {
       
        $query=$this->createQueryBuilder('j')
        ->select('j')
        ->orderBy('j.createdAt', 'DESC')
        ->leftJoin('j.category', 'c')
        ->leftJoin('j.type', 't')
        ->andWhere('j.user = :id')
        ->setParameter('id', $id);
        if(!empty($search->q))
        { 
            $query=$query
            ->andWhere('j.name LIKE :q')
            ->setParameter('q',"%{$search->q}%")
            ->orderBy('j.createdAt', 'DESC')
            ->setMaxResults(10);
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
            2
        );
    }
    //filter job with same parameters
    /**
     * @return PaginationInterface
     */
    public function findSearchHome(SearchData $search): PaginationInterface
    {
       
        $query=$this->createQueryBuilder('j')
        ->select('j')
        ->orderBy('j.createdAt', 'DESC')
        ->leftJoin('j.category', 'c')
        ->leftJoin('j.type', 't');
        if(!empty($search->q))
        { 
            $query=$query
            ->andWhere('j.name LIKE :q')
            ->setParameter('q',"%{$search->q}%")
            ->orderBy('j.createdAt', 'DESC')
            ->setMaxResults(10);
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
            2
        );
    }
    
   
   
}
