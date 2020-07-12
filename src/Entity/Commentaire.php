<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 */
class Commentaire
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
    private $commentaire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCommentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModeleChaussure", inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modele;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Commande", inversedBy="commentaires")
     */
    private $commandes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rating;
    /**
     * @var ArrayCollection
     */


    /**
     * @var ArrayCollection
     */


    public function __construct()
    {
        $this->commandes = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function setCommentaire( $commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDateCommentaire(): ?\DateTimeInterface
    {
        return $this->dateCommentaire;
    }

    public function setDateCommentaire(\DateTimeInterface $dateCommentaire): self
    {
        $this->dateCommentaire = $dateCommentaire;

        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient( $client)
    {
        $this->client = $client;

        return $this;
    }

    public function getModele(): ?ModeleChaussure
    {
        return $this->modele;
    }

    public function setModele(?ModeleChaussure $modele): self
    {
        $this->modele = $modele;

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

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating( $rating)
    {
        $this->rating = $rating;

        return $this;
    }

}
