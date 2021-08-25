<?php

namespace App\Entity;

use App\Repository\DirectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DirectionRepository::class)
 * @UniqueEntity(fields={"nomDirection"},message="Ce nom de direction existe déjà")
 */
class Direction
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=70)
     * @Assert\Length(min=2,minMessage="Le nom de la direction est au minimum 2 caractères",max=70,
     *                      maxMessage="Le nom de la direction est au minimum 70 caractères")
     * @Assert\NotBlank(message="Le nom de la direction est obligatoire")
     */
    private $nomDirection;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\Length(min=2,minMessage="La description est au minimum 2 caractères",max=80,
     *                      maxMessage="La description est au minimum 80 caractères")
     * @Assert\NotBlank(message="La description est obligatoire")
     */
    private $descrDir;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNomDirection(): string
    {
        return $this->nomDirection;
    }

    /**
     * @param string $nomDirection
     */
    public function setNomDirection(string $nomDirection)
    {
        $this->nomDirection = $nomDirection;
    }

    public function getDescrDir(): ?string
    {
        return $this->descrDir;
    }

    public function setDescrDir(string $descrDir): self
    {
        $this->descrDir = $descrDir;

        return $this;
    }
}
