<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdressRepository::class)
 */
class Adress
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $street;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private string $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $city;

    /**
     * @ORM\OneToMany(targetEntity=Garbage::class, mappedBy="adress")
     */
    private Collection $garbages;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="adress", orphanRemoval=true)
     */
    private Collection $users;

    public function __construct()
    {
        $this->garbages = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection|Garbage[]
     */
    public function getGarbages(): Collection
    {
        return $this->garbages;
    }

    public function addGarbage(Garbage $garbage): self
    {
        if (!$this->garbages->contains($garbage)) {
            $this->garbages[] = $garbage;
            $garbage->setAdress($this);
        }

        return $this;
    }

    public function removeGarbage(Garbage $garbage): self
    {
        if ($this->garbages->removeElement($garbage)) {
            // set the owning side to null (unless already changed)
            if ($garbage->getAdress() === $this) {
                $garbage->setAdress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAdress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAdress() === $this) {
                $user->setAdress(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return "$this->street $this->zipcode $this->city";
    }
}
