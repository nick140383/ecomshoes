<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ModeleChaussureRepository")
 */
class ModeleChaussure
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
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="modele")
     */
    private $commentaires;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commande", inversedBy="modeleChaussures")
     */
    private $commandes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Taille", inversedBy="modeleChaussures")
     */
    private $tailles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Promotion", mappedBy="modeleChaussure")
     */
    private $promotions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Marque", inversedBy="modeleChaussures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $marque;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo",cascade={"persist"},mappedBy="modeleChaussure")
     */
    private $photos;

    /**
     * @var photo
     */
    private $photo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;


    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->tailles = new ArrayCollection();
        $this->promotions = new ArrayCollection();
       $this->photos = new ArrayCollection();
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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setModele($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getModele() === $this) {
                $commentaire->setModele(null);
            }
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
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
        }

        return $this;
    }

    /**
     * @return Collection|Taille[]
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        if ($this->tailles->contains($taille)) {
            $this->tailles->removeElement($taille);
        }

        return $this;
    }

    /**
     * @return Collection|Promotion[]
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions[] = $promotion;
            $promotion->setModeleChaussure($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->contains($promotion)) {
            $this->promotions->removeElement($promotion);
            // set the owning side to null (unless already changed)
            if ($promotion->getModeleChaussure() === $this) {
                $promotion->setModeleChaussure(null);
            }
        }

        return $this;
    }

    public function getMarque(): ?Marque
    {
        return $this->marque;
    }

    public function setMarque(?Marque $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->nom;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos() :Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo)
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $this->photos->add($photo);
            $photo->setModeleChaussure($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getModeleChaussure() === $this) {
                $photo->setModeleChaussure(null);
            }
        }

        return $this;
    }




    public function setPhoto(photo $photos)
    {
        $this->$photos;
        return $this;
    }

    public function getPhoto(): ?photo
    {
        return $this->photo;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }


}