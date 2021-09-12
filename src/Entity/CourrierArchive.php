<?php

namespace App\Entity;

use App\Repository\CourrierArchiveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourrierArchiveRepository::class)
 */
class CourrierArchive
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="courrierArchives", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Courrier::class, inversedBy="courrierArchives")
     * @ORM\JoinColumn(nullable=false)
     */
    private $courrier;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isInTrashed = 0;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCourrier(): ?Courrier
    {
        return $this->courrier;
    }

    public function setCourrier(?Courrier $courrier): self
    {
        $this->courrier = $courrier;

        return $this;
    }

    public function getIsInTrashed(): ?bool
    {
        return $this->isInTrashed;
    }

    public function setIsInTrashed(bool $isInTrashed): self
    {
        $this->isInTrashed = $isInTrashed;

        return $this;
    }
}
