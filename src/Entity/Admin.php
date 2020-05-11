<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
/**
 * @Entity @Table(name="admin")
 */
/**
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 */
class Admin extends User
{
    /**
     * @Id @OneToOne(targetEntity="User",cascade={"persist"})
     * @JoinColumn(name="id", referencedColumnName="id")
     **/
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
