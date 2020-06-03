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
   
    // fonction qui permet de recuperer les users selon leur role
    public function findByRoles($value)
    {
        return $this->createQueryBuilder('u')
            //condition 
            ->andWhere('u.roles = :ROLE_EMPLOYEE')
            ->setParameter('ROLE_EMPLOYEE', $value) // sets ROLE_EMPLOYEE to value 
            //ordre ascendant d'affichage selon id 
            ->orderBy('u.id', 'ASC')
            //max de lignes affichés 
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
   //fonction qui permet de compter le nombre des entreprises possédant le role "ROLE_COMPANY"
    public function findLength()
    {
        return $this->createQueryBuilder('u')
        ->select('count(u.id)') //compter les entreprises 
        ->where('u.roles LIKE :role') //condition de select
        ->setParameter('role', '%"'.'ROLE_COMPANY'.'"%') // Sets :role  to ROLE_COMPANY
        ->getQuery()
        ->getSingleScalarResult();
    }

    //fonction qui permet de compter le nombre des employées  possédant le role "ROLE_EMPLOYEE"
    public function findLengthEmp()
    {
        return $this->createQueryBuilder('u')
        ->select('count(u.id)') //compter les employées 
        ->where('u.roles LIKE :role') //condition de select
        ->setParameter('role', '%"'.'ROLE_EMPLOYEE'.'"%') // Sets :role  to ROLE_EMPLOYEE
        ->getQuery()
        ->getSingleScalarResult();
    }

    //fonction de filtrage de  données des users 
    public function findSearch(SearchData $search): PaginationInterface
    {
       
        $query=$this->createQueryBuilder('u')
        ->select('u')
        ->leftJoin('u.category', 'cat');
        //filtre selon mot clé 
        if(!empty($search->q))
        { 
            $query=$query
            ->andWhere('u.username LIKE :q')
            ->setParameter('q',"%{$search->q}%")
            ->setMaxResults(10);
        }
        //filtre selon adresse
        if(!empty($search->l))
        { 
            $query=$query
            ->andWhere('u.location LIKE :l')
            ->setParameter('l',"%{$search->l}%")
            ->setMaxResults(10);
        }
        //filtre selon categorie
        if(!empty($search->categories)){
            $query=$query
            ->andwhere('cat.id IN (:categories)')
            ->setParameter('categories',$search->categories);
        }

        $query=$query->getQuery();
        //pagination 
        return $this->paginator->paginate(
            $query,
            $search->page,
           6
        );
    }
   // fonction de recuperation des users avec un maximum de 8
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
