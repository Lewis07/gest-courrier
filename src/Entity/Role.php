<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 * @UniqueEntity(fields={"titreRole"},message="Ce role existe déjà")
 */
class Role
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Length(max=20,maxMessage="Le nom de la direction est au minimum 20 caractères")
     * @Assert\NotBlank(message="Le role est obligatoire")
     */
    private $titreRole;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreRole(): ?string
    {
        return $this->titreRole;
    }

    public function getTitreRoleFormatted(): ?string
    {
        return  ucfirst(strtolower(str_replace("ROLE_","",$this->titreRole)));
    }

    public function setTitreRole(string $titreRole): self
    {
        $this->titreRole = $titreRole;

        return $this;
    }
}
