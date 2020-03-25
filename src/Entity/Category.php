<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
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
     * @ORM\OneToMany(targetEntity="App\Entity\Job", mappedBy="Category")
     */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Company", mappedBy="Category")
     */
    private $companies;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Employee", mappedBy="category")
     */
    private $employees;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
        $this->companies = new ArrayCollection();
        $this->employees = new ArrayCollection();
    }

    /**
     * @return Collection|jobs[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    /**
     * @return Collection|companies[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

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

    /**
     * @return Collection|Employee[]
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees[] = $employee;
            $employee->setCategory($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->contains($employee)) {
            $this->employees->removeElement($employee);
            // set the owning side to null (unless already changed)
            if ($employee->getCategory() === $this) {
                $employee->setCategory(null);
            }
        }

        return $this;
    }
}
