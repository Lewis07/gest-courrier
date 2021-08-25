<?php

namespace App\Entity;

use App\Repository\TypeDossierRepository;
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
}
