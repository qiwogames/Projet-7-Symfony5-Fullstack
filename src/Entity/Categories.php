<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriesRepository::class)
 */
class Categories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany (targetEntity="App\Entity\Produit", mappedBy="categories")
     * @ORM\JoinColumn (nullable=true)
     */
    private $produit;

    /**
     * @return array
     */
    public function getProduit(): array
    {
        return $this->produit;
    }

    /**
     * @param array $produit
     */
    public function setProduit(array $produit): void
    {
        $this->produit = $produit;
    }

    public function __construct()
    {
        $this->produit = array();
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomCategorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(?Produit $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }
}
