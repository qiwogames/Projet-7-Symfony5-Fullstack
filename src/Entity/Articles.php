<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 */
class Articles
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomArticle;

    /**
     * @ORM\Column(type="text")
     */
    private $contenuArticle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageArticle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $auteurArticle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateArticle;

    /**
     * @ORM\ManyToOne(targetEntity=CategoriesArticles::class, inversedBy="article_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoriesArticles;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomArticle(): ?string
    {
        return $this->nomArticle;
    }

    public function setNomArticle(string $nomArticle): self
    {
        $this->nomArticle = $nomArticle;

        return $this;
    }

    public function getContenuArticle(): ?string
    {
        return $this->contenuArticle;
    }

    public function setContenuArticle(string $contenuArticle): self
    {
        $this->contenuArticle = $contenuArticle;

        return $this;
    }

    public function getImageArticle(): ?string
    {
        return $this->imageArticle;
    }

    public function setImageArticle(string $imageArticle): self
    {
        $this->imageArticle = $imageArticle;

        return $this;
    }

    public function getAuteurArticle(): ?string
    {
        return $this->auteurArticle;
    }

    public function setAuteurArticle(string $auteurArticle): self
    {
        $this->auteurArticle = $auteurArticle;

        return $this;
    }

    public function getDateArticle(): ?\DateTimeInterface
    {
        return $this->dateArticle;
    }

    public function setDateArticle(\DateTimeInterface $dateArticle): self
    {
        $this->dateArticle = $dateArticle;

        return $this;
    }

    public function getCategoriesArticles(): ?CategoriesArticles
    {
        return $this->categoriesArticles;
    }

    public function setCategoriesArticles(?CategoriesArticles $categoriesArticles): self
    {
        $this->categoriesArticles = $categoriesArticles;

        return $this;
    }
}
