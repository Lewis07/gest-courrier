<?php

namespace App\Entity;

use App\Repository\PartageCourrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartageCourrierRepository::class)
 */
class PartageCourrier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="partageCourriers", cascade={"persist", "remove"})
     */
    private $sharer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="envoyeur", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    public function __construct()
    {
        $this->sharer = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getSharer(): Collection
    {
        return $this->sharer;
    }

    public function addSharer(User $sharer): self
    {
        if (!$this->sharer->contains($sharer)) {
            $this->sharer[] = $sharer;
        }

        return $this;
    }

    public function removeSharer(User $sharer): self
    {
        $this->sharer->removeElement($sharer);

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }
}
