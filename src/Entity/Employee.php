<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployeeRepository")
 */
class Employee
{

    public function __construct()
    {
       // $this->created_at = new DateTime();
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
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prof;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comp1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comp2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comp3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comp4;

    /**
     * @ORM\Column(type="integer")
     */
    private $salary;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="employees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeJob", inversedBy="employees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $education;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $experience;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;
    
    
  

 
 

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getProf(): ?string
    {
        return $this->prof;
    }

    public function setProf(string $prof): self
    {
        $this->prof = $prof;

        return $this;
    }

    public function getComp1(): ?string
    {
        return $this->comp1;
    }

    public function setComp1(string $comp1): self
    {
        $this->comp1 = $comp1;

        return $this;
    }

    public function getComp2(): ?string
    {
        return $this->comp2;
    }

    public function setComp2(string $comp2): self
    {
        $this->comp2 = $comp2;

        return $this;
    }

    public function getComp3(): ?string
    {
        return $this->comp3;
    }

    public function setComp3(string $comp3): self
    {
        $this->comp3 = $comp3;

        return $this;
    }

    public function getComp4(): ?string
    {
        return $this->comp4;
    }

    public function setComp4(string $comp4): self
    {
        $this->comp4 = $comp4;

        return $this;
    }

    public function getSalary(): ?int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): self
    {
        $this->salary= $salary;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEducation(): ?string
    {
        return $this->education;
    }

    public function setEducation(string $education): self
    {
        $this->education = $education;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }



}
