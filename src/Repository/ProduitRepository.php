<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */

    public function getDernierProduit()
    {
        //Ici on creer une variable qui apple la methode createQueryBuilder de Doctrine et prend un alias en paramètre
        //De cette manière pas besoin d'ecrire de SQL en DUR
        //A noter que Symfony permet de chainer les methodes
        $dernierProduit = $this->createQueryBuilder('p')
            //On utilise l'alias p pour recup id et trier par order decroissant
            ->orderBy('p.id', 'DESC')
            //Un seul element
            ->setMaxResults(1)
            //Parcours des resultats
            ->getQuery()
            //getOneOrNullResult() = recupère un objet ou une valeur null (erreur si plusieur objet)
            ->getOneOrNullResult();

        //retourne le resultat de ma requète
        return $dernierProduit;
    }



    public function rechecheParPrixRef(PropertySearch $search): Query
    {
        $query = $this->findAll();

        if($search->getCategories()){
            $query = $this->createQueryBuilder('p')
                ->andWhere('p.categories = :categories')
                ->setParameter('categories', $search->getCategories());
        }

        if($search->getMaxPrix()){
            $query = $this->createQueryBuilder('p')
                ->andWhere('p.prixProduit <= :maxprix')
                ->setParameter('maxprix', $search->getMaxPrix());
        }

        return $query->getQuery();
    }

}
