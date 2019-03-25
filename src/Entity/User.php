<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Logboek", mappedBy="userId")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Logboek", mappedBy="chauffeurId")
     */
    private $chauffeurs;

    public function __construct()
    {
        parent::__construct();
        $this->users = new ArrayCollection();
        $this->chauffeurs = new ArrayCollection();
        // your own logic
    }

    /**
     * @return Collection|Logboek[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Logboek $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setUserId($this);
        }

        return $this;
    }

    public function removeUser(Logboek $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getUserId() === $this) {
                $user->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Logboek[]
     */
    public function getChauffeurs(): Collection
    {
        return $this->chauffeurs;
    }

    public function addChauffeur(Logboek $chauffeur): self
    {
        if (!$this->chauffeurs->contains($chauffeur)) {
            $this->chauffeurs[] = $chauffeur;
            $chauffeur->setChauffeurId($this);
        }

        return $this;
    }

    public function removeChauffeur(Logboek $chauffeur): self
    {
        if ($this->chauffeurs->contains($chauffeur)) {
            $this->chauffeurs->removeElement($chauffeur);
            // set the owning side to null (unless already changed)
            if ($chauffeur->getChauffeurId() === $this) {
                $chauffeur->setChauffeurId(null);
            }
        }

        return $this;
    }
}
