<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
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
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="ville")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Livraison", mappedBy="ville")
     */
    private $livraisons;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fournisseur", mappedBy="ville")
     */
    private $fournisseurs;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
        $this->fournisseurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
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
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setVille($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getVille() === $this) {
                $client->setVille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Livraison[]
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setVille($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->contains($livraison)) {
            $this->livraisons->removeElement($livraison);
            // set the owning side to null (unless already changed)
            if ($livraison->getVille() === $this) {
                $livraison->setVille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Fournisseur[]
     */
    public function getFournisseurs(): Collection
    {
        return $this->fournisseurs;
    }

    public function addFournisseur(Fournisseur $fournisseur): self
    {
        if (!$this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs[] = $fournisseur;
            $fournisseur->setVille($this);
        }

        return $this;
    }

    public function removeFournisseur(Fournisseur $fournisseur): self
    {
        if ($this->fournisseurs->contains($fournisseur)) {
            $this->fournisseurs->removeElement($fournisseur);
            // set the owning side to null (unless already changed)
            if ($fournisseur->getVille() === $this) {
                $fournisseur->setVille(null);
            }
        }

        return $this;
    }
}
