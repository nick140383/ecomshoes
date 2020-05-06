<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MarqueRepository")
 */
class Marque
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
     * @ORM\OneToMany(targetEntity="App\Entity\ModeleChaussure", mappedBy="marque")
     */
    private $modeleChaussures;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fournisseur", inversedBy="marques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fournisseur;

    public function __construct()
    {
        $this->modeleChaussures = new ArrayCollection();
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

    /**
     * @return Collection|ModeleChaussure[]
     */
    public function getModeleChaussures(): Collection
    {
        return $this->modeleChaussures;
    }

    public function addModeleChaussure(ModeleChaussure $modeleChaussure): self
    {
        if (!$this->modeleChaussures->contains($modeleChaussure)) {
            $this->modeleChaussures[] = $modeleChaussure;
            $modeleChaussure->setMarque($this);
        }

        return $this;
    }

    public function removeModeleChaussure(ModeleChaussure $modeleChaussure): self
    {
        if ($this->modeleChaussures->contains($modeleChaussure)) {
            $this->modeleChaussures->removeElement($modeleChaussure);
            // set the owning side to null (unless already changed)
            if ($modeleChaussure->getMarque() === $this) {
                $modeleChaussure->setMarque(null);
            }
        }

        return $this;
    }

    public function getFournisseur(): ?Fournisseur
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseur $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->nom;
    }


}
