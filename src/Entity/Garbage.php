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
}