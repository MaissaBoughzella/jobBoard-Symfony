<?php
// src/Entity/User.php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\MappedSuperclass; 
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
//use Symfony\Component\Validator\Constraints\DateTime;
/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */

 /**
  * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */


 class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Job", mappedBy="user")
     */
    private $jobs;


    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

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
     * @ORM\Column(type="string", length=255)
     */
    
    private $salary;
    /**
     * @ORM\Column(type="datetime" ,options={"default": "CURRENT_TIMESTAMP"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "data:image/png;base64,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"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeJob", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $education;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $experience;

   


    public function __construct() {
        //$this->type= new TypeJob();
        $this->created_at = new \DateTime();
        $this->jobs = new ArrayCollection();
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

    
    public function getId()
    {
        return $this->id;
    }

    // public function setId(integer $id): self
    // {
    //     $this->id = $id;

    //     return $this;
    // }

     /**
     * @return Collection|Job[]
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): self
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs[] = $job;
            $job->setUser($this);
        }

        return $this;
    }
    // other properties and methods

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

   

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }
    public function getRoles(): array
    {
        $roles = $this->roles;

        // Afin d'être sûr qu'un user a toujours au moins 1 rôle
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles($roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

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
    public function eraseCredentials()
    {
    }


}