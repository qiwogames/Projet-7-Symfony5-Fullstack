<?php

namespace App\Entity;

use App\Repository\DistributeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DistributeurRepository::class)
 */
class Distributeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany (targetEntity="App\Entity\Produit", mappedBy="distributeurs")
     * @ORM\JoinColumn (nullable=true)
     */
    private $produit;

    /**
     * @ORM\ManyToMany (targetEntity="App\Entity\Produit", mappedBy="ajouter_distributeurs")
     * @ORM\JoinColumn (nullable=true)
     */
    private $ajouter_distributeur;

    /**
     * @return ArrayCollection
     */
    public function getAjouterDistributeur(): ArrayCollection
    {
        return $this->ajouter_distributeur;
    }

    /**
     * @param ArrayCollection $ajouter_distributeur
     */
    public function setAjouterDistributeur(ArrayCollection $ajouter_distributeur): void
    {
        $this->ajouter_distributeur = $ajouter_distributeur;
    }



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomDistributeur;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
        $this->ajouter_distributeur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDistributeur(): ?string
    {
        return $this->nomDistributeur;
    }

    public function setNomDistributeur(string $nomDistributeur): self
    {
        $this->nomDistributeur = $nomDistributeur;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
            $produit->addDistributeur($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            $produit->removeDistributeur($this);
        }

        return $this;
    }

    public function addAjouterDistributeur(Produit $ajouterDistributeur): self
    {
        if (!$this->ajouter_distributeur->contains($ajouterDistributeur)) {
            $this->ajouter_distributeur[] = $ajouterDistributeur;
            $ajouterDistributeur->addAjouterDistributeur($this);
        }

        return $this;
    }

    public function removeAjouterDistributeur(Produit $ajouterDistributeur): self
    {
        if ($this->ajouter_distributeur->removeElement($ajouterDistributeur)) {
            $ajouterDistributeur->removeAjouterDistributeur($this);
        }

        return $this;
    }
}
