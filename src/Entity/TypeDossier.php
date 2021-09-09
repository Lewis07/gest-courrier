<?php

namespace App\Entity;

use App\Repository\TypeDossierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TypeDossierRepository::class)
 * @UniqueEntity(fields={"libelleTypeDossier"},message="Ce type de dossier existe déjà")
 */
class TypeDossier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=90)
     * @Assert\Length(max=90,maxMessage="Le nom de la direction est au minimum 90 caractères")
     * @Assert\NotBlank(message="Le fonction est obligatoire")
     */
    private $libelleTypeDossier;

    /**
     * @ORM\OneToMany(targetEntity=Dossier::class, mappedBy="typDos")
     */
    private $dossiers;

    public function __construct()
    {
        $this->dossiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleTypeDossier(): ?string
    {
        return $this->libelleTypeDossier;
    }

    public function setLibelleTypeDossier(string $libelleTypeDossier): self
    {
        $this->libelleTypeDossier = $libelleTypeDossier;

        return $this;
    }

    /**
     * @return Collection|Dossier[]
     */
    public function getDossiers(): Collection
    {
        return $this->dossiers;
    }

    public function addDossier(Dossier $dossier): self
    {
        if (!$this->dossiers->contains($dossier)) {
            $this->dossiers[] = $dossier;
            $dossier->setTypDos($this);
        }

        return $this;
    }

    public function removeDossier(Dossier $dossier): self
    {
        if ($this->dossiers->removeElement($dossier)) {
            // set the owning side to null (unless already changed)
            if ($dossier->getTypDos() === $this) {
                $dossier->setTypDos(null);
            }
        }

        return $this;
    }
}
