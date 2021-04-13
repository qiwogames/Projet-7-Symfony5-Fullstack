<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use App\Validator\Antispam;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 * @UniqueEntity(fields="nomProduit", message="Erreur : un produit possède déja ce nom dans notre base de données", groups={"produits"})
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=2, max=50, minMessage="Le nom du produit doit avoir au moin {{ limit }} caratères", maxMessage="Le nom du produit doit avoir au maximum {{ limit }} caratères", groups="all"
     * )
     * @Antispam(message="Le nom du produit : %string% ne doit contenir que des caracètères alphanumeriques", groups="all")
     */
    private $nomProduit;

    /**
     * @ORM\Column(type="float")
     * @Assert\Type("float", message="Le prix du produit {{ value }} n'est pas une donnée valide {{type}}"), groups="all"
     */
    private $prixProduit;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Type("integer", message="La quantité du produit {{ value }} n'est pas une donnée valide : {{ type }}"), groups="all"
     */
    private $quantiteProduit;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rupture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(maxSize="6000000", maxSizeMessage="Le fichier est trop lourd ({{ size }} {{ suffix }}). La taille maximale autorisée est : {{ limit }} {{ suffix }}"), groups="all"
     */
    private $photoProduit;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Reference", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     * @return int|null
     */
    private $reference;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Distributeur",inversedBy="produit", cascade={"persist"})
     * @ORM\JoinColumn (nullable=true)
     */
    private $distributeurs;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Distributeur",inversedBy="produit", cascade={"persist"})
     * @ORM\JoinColumn (nullable=true)
     */
    private $ajouter_distributeurs;

    /**
     * @return mixed
     */
    public function getAjouterDistributeurs()
    {
        return $this->ajouter_distributeurs;
    }

    /**
     * @param mixed $ajouter_distributeurs
     */
    public function setAjouterDistributeurs($ajouter_distributeurs): void
    {
        $this->ajouter_distributeurs = $ajouter_distributeurs;
    }

    public function __construct()
    {
        $this->distributeurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getPrixProduit(): ?float
    {
        return $this->prixProduit;
    }

    public function setPrixProduit(float $prixProduit): self
    {
        $this->prixProduit = $prixProduit;

        return $this;
    }

    public function getQuantiteProduit(): ?int
    {
        return $this->quantiteProduit;
    }

    public function setQuantiteProduit(int $quantiteProduit): self
    {
        $this->quantiteProduit = $quantiteProduit;

        return $this;
    }

    /**
     * @return bool|null
     * @Assert\IsTrue(message="Erreur: la quantité et le prix ne peuvent pas etre une valeur négative"), groups="all"
     */
    public function isPrixQuantiteValid(){
        if(is_float($this->getPrixProduit()) && (is_int($this->getQuantiteProduit())) && ($this->getPrixProduit() > 0) && ($this->quantiteProduit) >0){
                return  true;
            }else{
                return  false;
        }
    }

    public function getRupture(): ?bool
    {
        return $this->rupture;
    }

    public function setRupture(bool $rupture): self
    {
        $this->rupture = $rupture;

        return $this;
    }

    public function getPhotoProduit(): ?string
    {
        return $this->photoProduit;
    }

    public function setPhotoProduit(string $photoProduit): self
    {
        $this->photoProduit = $photoProduit;

        return $this;
    }

    public function getReference(): ?Reference
    {
        return $this->reference;
    }

    public function setReference(?Reference $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Collection|Distributeur[]
     */
    public function getDistributeurs(): Collection
    {
        return $this->distributeurs;
    }

    public function addDistributeur(Distributeur $distributeur): self
    {
        if (!$this->distributeurs->contains($distributeur)) {
            //Prise en compte des relation inverse
            $distributeur->addProduit($this);
        }

        return $this;
    }

    public function removeDistributeur(Distributeur $distributeur): self
    {
        $this->distributeurs->removeElement($distributeur);

        return $this;
    }

    /**
     * @Assert\Callback(), groups="all"
     */
    public function isContentValid(ExecutionContextInterface $context){
        //Liste de mot interdit
        $forbidenWords = array('arme', 'médicament', 'drogue');
        //c cette condition qui fait letravail = si $this->getNomProduit contient un mot de la liste on declenche une erreur
        //#i indique que le champ est insessible a la casse (majuscule + minuscule)
        if(preg_match('#'.implode('|', $forbidenWords).'#i', $this->getNomProduit())){
            //Erreur de validation
            $context->buildViolation('Ce produit est interdit à la vente')
                ->atPath('produit')
                ->addViolation();
        }
    }

    /**
     * Generer les methodes magiques
     *
     */
    public function __toString(){
        // Le nom du produit
        return $this->nomProduit;
    }
}
