<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 * fields={"email"},
 * message= "L'email que vous avez indiqué est déjà utilisé !" )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $Fonction;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath="Password", message="Vous n'avez pas tapé le même mot de passe")
     */
    Public $confirm_password;

    /**
     * @ORM\OneToMany(targetEntity=Courrier::class, mappedBy="sender", orphanRemoval=true)
     */
    private $sent;
                                                                                        
    /**
     * @ORM\OneToMany(targetEntity=Courrier::class, mappedBy="recipient", orphanRemoval=true)
     */
    private $received;
    
    /**
    * @ORM\Column(type="json")
    */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=PartageCourrier::class, mappedBy="sharer")
     */
    private $partageur;

    /**
     * @ORM\ManyToMany(targetEntity=PartageCourrier::class, mappedBy="sharer")
     */
    private $partageCourriers;

    /**
     * @ORM\OneToMany(targetEntity=PartageCourrier::class, mappedBy="sender")
     */
    private $envoyeur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    public function __construct()
    {
        $this->courriers = new ArrayCollection();
        $this->recevoir = new ArrayCollection();
        $this->sent = new ArrayCollection();
        $this->received = new ArrayCollection();
        $this->partageCourriers = new ArrayCollection();
        $this->envoyeur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->Fonction;
    }

    public function setFonction(string $Fonction): self
    {
        $this->Fonction = $Fonction;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
       
    }
    public function getSalt()
    {
        
    }

    public function getRoles(): array
    {
        $role = json_encode($this->roles);
        //dd($role);
        //guarantee every User at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        $roles[] = 'ROLE_ADMIN';
        //return array_unique($roles);
        return $this->roles;
    }

    /**
     * @return Collection|Courrier[]
     */
    public function getSent(): Collection
    {
        return $this->sent;
    }

    public function addSent(Courrier $sent): self
    {
        if (!$this->sent->contains($sent)) {
            $this->sent[] = $sent;
            $sent->setSender($this);
        }

        return $this;
    }

    public function removeSent(Courrier $sent): self
    {
        if ($this->sent->removeElement($sent)) {
            // set the owning side to null (unless already changed)
            if ($sent->getSender() === $this) {
                $sent->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Courrier[]
     */
    public function getReceived(): Collection
    {
        return $this->received;
    }

    public function addReceived(Courrier $received): self
    {
        if (!$this->received->contains($received)) {
            $this->received[] = $received;
            $received->setRecipient($this);
        }

        return $this;
    }

    public function removeReceived(Courrier $received): self
    {
        if ($this->received->removeElement($received)) {
            // set the owning side to null (unless already changed)
            if ($received->getRecipient() === $this) {
                $received->setRecipient(null);
            }
        }

        return $this;
    }

    public function setRoles($roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function __toString()
    {
        return (string) $this->roles;
    }

    /**
     * @return Collection|PartageCourrier[]
     */
    public function getPartageCourriers(): Collection
    {
        return $this->partageCourriers;
    }

    public function addPartageCourrier(PartageCourrier $partageCourrier): self
    {
        if (!$this->partageCourriers->contains($partageCourrier)) {
            $this->partageCourriers[] = $partageCourrier;
            $partageCourrier->addSharer($this);
        }

        return $this;
    }

    public function removePartageCourrier(PartageCourrier $partageCourrier): self
    {
        if ($this->partageCourriers->removeElement($partageCourrier)) {
            $partageCourrier->removeSharer($this);
        }

        return $this;
    }

    /**
     * @return Collection|PartageCourrier[]
     */
    public function getEnvoyeur(): Collection
    {
        return $this->envoyeur;
    }

    public function addEnvoyeur(PartageCourrier $envoyeur): self
    {
        if (!$this->envoyeur->contains($envoyeur)) {
            $this->envoyeur[] = $envoyeur;
            $envoyeur->setSender($this);
        }

        return $this;
    }

    public function removeEnvoyeur(PartageCourrier $envoyeur): self
    {
        if ($this->envoyeur->removeElement($envoyeur)) {
            // set the owning side to null (unless already changed)
            if ($envoyeur->getSender() === $this) {
                $envoyeur->setSender(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
