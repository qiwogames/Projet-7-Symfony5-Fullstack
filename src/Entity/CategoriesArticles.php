<?php

namespace App\Entity;

use App\Repository\CategoriesArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoriesArticlesRepository::class)
 */
class CategoriesArticles
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
    private $nomCategorie;

    /**
     * @ORM\OneToMany(targetEntity=Articles::class, mappedBy="categoriesArticles")
     */
    private $article_id;

    public function __construct()
    {
        $this->article_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getArticleId(): Collection
    {
        return $this->article_id;
    }

    public function addArticleId(Articles $articleId): self
    {
        if (!$this->article_id->contains($articleId)) {
            $this->article_id[] = $articleId;
            $articleId->setCategoriesArticles($this);
        }

        return $this;
    }

    public function removeArticleId(Articles $articleId): self
    {
        if ($this->article_id->removeElement($articleId)) {
            // set the owning side to null (unless already changed)
            if ($articleId->getCategoriesArticles() === $this) {
                $articleId->setCategoriesArticles(null);
            }
        }

        return $this;
    }
}
