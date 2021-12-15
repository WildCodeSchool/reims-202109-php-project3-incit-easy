<?php

namespace App\Entity;

use App\Repository\GarbageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GarbageRepository::class)
 */
class Garbage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="float")
     */
    private float $recycledWaste;

    /**
     * @ORM\Column(type="float")
     */
    private float $nonRecycledWaste;

    /**
     * @ORM\Column(type="datetime_immutable", options={"default": "CURRENT_TIMESTAMP"})
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="garbages")
     */
    private ?User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

     /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getRecycledWaste(): ?float
    {
        return $this->recycledWaste;
    }

    public function setRecycledWaste(float $recycledWaste): self
    {
        $this->recycledWaste = $recycledWaste;

        return $this;
    }

    public function getNonRecycledWaste(): ?float
    {
        return $this->nonRecycledWaste;
    }

    public function setNonRecycledWaste(float $nonRecycledWaste): self
    {
        $this->nonRecycledWaste = $nonRecycledWaste;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
