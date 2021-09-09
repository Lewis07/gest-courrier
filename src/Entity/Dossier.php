<?php

namespace App\Entity;

use App\Repository\DossierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DossierRepository::class)
 */
class Dossier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Courrier::class, inversedBy="dossiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $courrier;

    /**
     * @ORM\ManyToOne(targetEntity=TypeDossier::class, inversedBy="dossiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typDos;
    
    public function getId(): ?int
    {
        return $this->id;
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

    public function getTypDos(): ?TypeDossier
    {
        return $this->typDos;
    }

    public function setTypDos(?TypeDossier $typDos): self
    {
        $this->typDos = $typDos;

        return $this;
    }
    
}