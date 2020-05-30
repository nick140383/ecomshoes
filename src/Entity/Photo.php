<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



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
    protected $url;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModeleChaussure", inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $modeleChaussure;


    public function __construct()
    {


        $this->modeleChaussure = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return Collection|ModeleChaussure[]
     */
    public function getModeleChaussure(): Collection
    {
        return $this->modeleChaussure;
    }

    public function add(ModeleChaussure $modeleChaussure): self
    {
        if (!$this->modeleChaussure->contains($modeleChaussure)) {
            $this->modeleChaussure[] = $modeleChaussure;
            $modeleChaussure->setPhoto($this);
        }

        return $this;
    }

    public function remove(ModeleChaussure $modeleChaussure): self
    {
        if ($this->modeleChaussure->contains($modeleChaussure)) {
            $this->modeleChaussure->removeElement($modeleChaussure);
            // set the owning side to null (unless already changed)
            if ($modeleChaussure->getPhoto() === $this) {
                $modeleChaussure->setPhoto(null);
            }
        }

        return $this;
    }


    public function setModeleChaussure(?ModeleChaussure $modeleChaussure)
    {
        $this->modeleChaussure = $modeleChaussure;

        return $this;
    }

    public function setUrl( $url)
    {
        $this->url=$url;
        return $this;
    }






}