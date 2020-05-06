<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TailleRepository")
 */
class Taille
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $taille;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ModeleChaussure", mappedBy="tailles")
     */
    private $modeleChaussures;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commande", mappedBy="tailles")
     */
    private $commandes;

    public function __construct()
    {
        $this->modeleChaussures = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): self
    {
        $this->taille = $taille;

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
            $modeleChaussure->addTaille($this);
        }

        return $this;
    }

    public function removeModeleChaussure(ModeleChaussure $modeleChaussure): self
    {
        if ($this->modeleChaussures->contains($modeleChaussure)) {
            $this->modeleChaussures->removeElement($modeleChaussure);
            $modeleChaussure->removeTaille($this);
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addTaille($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            $commande->removeTaille($this);
        }

        return $this;
    }
}
