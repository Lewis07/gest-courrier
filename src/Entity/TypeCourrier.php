<?php

namespace App\Entity;

use App\Repository\TypeCourrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TypeCourrierRepository::class)
 * @UniqueEntity(fields={"libelleTypeCourrier"},message="Ce type de courrier existe déjà")
 */
class TypeCourrier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=90)
     * @Assert\Length(max=90,maxMessage="Le type de courrier est au minimum 90 caractères")
     * @Assert\NotBlank(message="Le type de courrier est obligatoire")
     */
    private $libelleTypeCourrier;

    /**
     * @ORM\OneToMany(targetEntity=Courrier::class, mappedBy="typeCourrier", cascade={"persist","remove"})
     */
    private $courriers;

    public function __construct()
    {
        $this->courriers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleTypeCourrier(): ?string
    {
        return $this->libelleTypeCourrier;
    }

    public function setLibelleTypeCourrier(string $libelleTypeCourrier): self
    {
        $this->libelleTypeCourrier = $libelleTypeCourrier;

        return $this;
    }

    /**
     * @return Collection|Courrier[]
     */
    public function getCourriers(): Collection
    {
        return $this->courriers;
    }

    public function addCourrier(Courrier $courrier): self
    {
        if (!$this->courriers->contains($courrier)) {
            $this->courriers[] = $courrier;
            $courrier->setTypeCourrier($this);
        }

        return $this;
    }

    public function removeCourrier(Courrier $courrier): self
    {
        if ($this->courriers->removeElement($courrier)) {
            // set the owning side to null (unless already changed)
            if ($courrier->getTypeCourrier() === $this) {
                $courrier->setTypeCourrier(null);
            }
        }

        return $this;
    }
}