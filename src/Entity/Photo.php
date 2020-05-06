<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\This;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotoRepository")
 */
class Photo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ModeleChaussure", mappedBy="photo")
     */
    private $modeles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModeleChaussure", inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modeleChaussure;

    public function __construct()
    {
        $this->modeles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return Collection|ModeleChaussure[]
     */
    public function getModeles(): Collection
    {
        return $this->modeles;
    }

    public function addModele(ModeleChaussure $modele): self
    {
        if (!$this->modeles->contains($modele)) {
            $this->modeles[] = $modele;
            $modele->setPhoto($this);
        }

        return $this;
    }

    public function removeModele(ModeleChaussure $modele): self
    {
        if ($this->modeles->contains($modele)) {
            $this->modeles->removeElement($modele);
            // set the owning side to null (unless already changed)
            if ($modele->getPhoto() === $this) {
                $modele->setPhoto(null);
            }
        }

        return $this;
    }

    public function getModeleChaussure(): ?ModeleChaussure
    {
        return $this->modeleChaussure;
    }

    public function setModeleChaussure(?ModeleChaussure $modeleChaussure): self
    {
        $this->modeleChaussure = $modeleChaussure;

        return $this;
    }

    public function setUrl(string $string)
    {
       $this->url;
        return $this;
    }
}
