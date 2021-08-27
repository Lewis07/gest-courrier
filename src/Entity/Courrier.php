<?php

namespace App\Entity;

use App\Repository\CourrierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourrierRepository::class)
 */
class Courrier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateEnvoie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $objetCourrier;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $typeCourrier;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isValid = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isRead = 0;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="received")
     * @ORM\JoinColumn(nullable=true)
     */
    private $recipient;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isArchived = 0;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isInTrashed = 0;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isSend = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fichier;

    /**
     * @ORM\OneToMany(targetEntity=CourrierArchive::class, mappedBy="courrier")
     */
    private $courrierArchives;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $reference;

    public function __construct()
    {
        $this->dateEnvoie= new \DateTime();
        $this->courrierArchives = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(\DateTimeInterface $dateEnvoie): self
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    public function getObjetCourrier(): ?string
    {
        return $this->objetCourrier;
    }

    public function setObjetCourrier(string $objetCourrier): self
    {
        $this->objetCourrier = $objetCourrier;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getTypeCourrier(): ?string
    {
        return $this->typeCourrier;
    }

    public function setTypeCourrier(string $typeCourrier): self
    {
        $this->typeCourrier = $typeCourrier;

        return $this;
    }

    public function getIsValid(): ?bool
    {
        return $this->isValid;
    }

    public function setIsValid(bool $isValid): self
    {
        $this->isValid = $isValid;

        return $this;
    }

    public function getIsRead(): ?bool
    {
        return $this->isRead;
    }

    public function setIsRead(bool $isRead): self
    {
        $this->isRead = $isRead;

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

    public function getRecipient(): ?User
    {
        return $this->recipient;
    }

    public function setRecipient(?User $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getIsArchived(): ?bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(?bool $isArchived): self
    {
        $this->isArchived = $isArchived;

        return $this;
    }

    public function getIsInTrashed(): ?bool
    {
        return $this->isInTrashed;
    }

    public function setIsInTrashed(?bool $isInTrashed): self
    {
        $this->isInTrashed = $isInTrashed;

        return $this;
    }

    public function getIsSend(): ?bool
    {
        return $this->isSend;
    }

    public function setIsSend(?bool $isSend): self
    {
        $this->isSend = $isSend;

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(?string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    /**
     * @return Collection|CourrierArchive[]
     */
    public function getCourrierArchives(): Collection
    {
        return $this->courrierArchives;
    }

    public function addCourrierArchive(CourrierArchive $courrierArchive): self
    {
        if (!$this->courrierArchives->contains($courrierArchive)) {
            $this->courrierArchives[] = $courrierArchive;
            $courrierArchive->setCourrier($this);
        }

        return $this;
    }

    public function removeCourrierArchive(CourrierArchive $courrierArchive): self
    {
        if ($this->courrierArchives->removeElement($courrierArchive)) {
            // set the owning side to null (unless already changed)
            if ($courrierArchive->getCourrier() === $this) {
                $courrierArchive->setCourrier(null);
            }
        }

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

}