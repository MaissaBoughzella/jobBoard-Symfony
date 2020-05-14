<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
{
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->user = new ArrayCollection();
    }
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="datetime" ,options={"default": "CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $wage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="Job")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeJob", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="jobs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $experience;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $offre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $req;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $req2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $req3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $req4;

   

   



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getWage(): ?string
    {
        return $this->wage;
    }

    public function setWage(string $wage): self
    {
        $this->wage = $wage;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getType(): ?TypeJob
    {
        return $this->type;
    }

    public function setType(?TypeJob $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getOffre(): ?string
    {
        return $this->offre;
    }

    public function setOffre(string $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReq(): ?string
    {
        return $this->req;
    }

    public function setReq(string $req): self
    {
        $this->req = $req;

        return $this;
    }

    public function getReq2(): ?string
    {
        return $this->req2;
    }

    public function setReq2(string $req2): self
    {
        $this->req2 = $req2;

        return $this;
    }

    public function getReq3(): ?string
    {
        return $this->req3;
    }

    public function setReq3(string $req3): self
    {
        $this->req3 = $req3;

        return $this;
    }

    public function getReq4(): ?string
    {
        return $this->req4;
    }

    public function setReq4(string $req4): self
    {
        $this->req4 = $req4;

        return $this;
    }





   


}
