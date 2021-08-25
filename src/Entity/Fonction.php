<?php

namespace App\Entity;

use App\Repository\FonctionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FonctionRepository::class)
 * @UniqueEntity(fields={"nomFonction"},message="Ce role existe déjà")
 */
class Fonction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\Length(max=60,maxMessage="Le nom de la direction est au minimum 60 caractères")
     * @Assert\NotBlank(message="Le fonction est obligatoire")
     */
    private $nomFonction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFonction(): ?string
    {
        return $this->nomFonction;
    }

    public function setNomFonction(string $nomFonction): self
    {
        $this->nomFonction = $nomFonction;

        return $this;
    }
}
