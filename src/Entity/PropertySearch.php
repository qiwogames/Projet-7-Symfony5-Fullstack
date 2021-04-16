<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Integer;

class PropertySearch
{
    //ICI PAS ORM DOCTRINE -> Recherche par prix et categorie


    /**
     * @var
     */

    private $categories;

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories): void
    {
        $this->categories = $categories;
    }


    /**
     * @return int|null
     */
    public function getMaxPrix(): ?int
    {
        return $this->maxPrix;
    }

    /**
     * @param int|null $maxPrix
     */
    public function setMaxPrix(?int $maxPrix): void
    {
        $this->maxPrix = $maxPrix;
    }

    //Un entier ou null
    /**
     * @var int|null
     */
    private $maxPrix;


}