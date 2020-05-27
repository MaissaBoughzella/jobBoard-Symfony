<?php

namespace App\Repository;

use App\Entity\User;
use App\Data\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, User::class);
        $this->paginator=$paginator;
    }

    /**
     * @return User[] Returns an array of User objects
     */
   
    public function findByRoles($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles = :ROLE_EMPLOYEE')
            ->setParameter('ROLE_EMPLOYEE', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
   

    
    //public function findOneBySomeField($value): ?User
    // {
    //     return $this->createQueryBuilder('u')
    //         ->andWhere('u.exampleField = :val')
    //         ->setParameter('val', $value)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
    


    public function findSearch(SearchData $search): PaginationInterface
    {
       
        $query=$this->createQueryBuilder('u')
        ->select('u')
        ->leftJoin('u.category', 'cat');
        if(!empty($search->q))
        { 
            $query=$query
            ->andWhere('u.username LIKE :q')
            ->setParameter('q',"%{$search->q}%")
            ->setMaxResults(10);
        }

        if(!empty($search->l))
        { 
            $query=$query
            ->andWhere('u.location LIKE :l')
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
           6
        );
    }

    public function findU()
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult()
        ;
    }

    
    
}
