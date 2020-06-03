<?php

namespace App\Repository;

use App\Entity\MessageAdmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MessageAdmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessageAdmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessageAdmin[]    findAll()
 * @method MessageAdmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageAdminRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageAdmin::class);
    }

    /*fonction qui permet de recuperer tous les messages de l'admin au utilisateurs 
  avec un ordre descendant selon la date d'envoi des messages */

    public function findAll()
    {
        return $this->findBy(array(), array('created_at' => 'DESC'));
    }

    // /**
    //  * @return MessageAdmin[] Returns an array of MessageAdmin objects
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
    public function findOneBySomeField($value): ?MessageAdmin
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
