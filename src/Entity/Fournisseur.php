<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FournisseurRepository")
 */
class Fournisseur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Marque", mappedBy="fournisseur")
     */
    private $marques;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="fournisseurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ville;

    public function __construct()
    {
        $this->marques = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    /**
     * @return Collection|Marque[]
     */
    public function getMarques(): Collection
    {
        return $this->marques;
    }

    public function addMarque(Marque $marque): self
    {
        if (!$this->marques->contains($marque)) {
            $this->marques[] = $marque;
            $marque->setFournisseur($this);
        }

        return $this;
    }

    public function removeMarque(Marque $marque): self
    {
        if ($this->marques->contains($marque)) {
            $this->marques->removeElement($marque);
            // set the owning side to null (unless already changed)
            if ($marque->getFournisseur() === $this) {
                $marque->setFournisseur(null);
            }
        }

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }
}
