<?php

namespace App\Controller;

use App\Entity\Distributeur;
use App\Entity\Produit;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\ProduitRepository;
use Cocur\Slugify\Slugify;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListeProduitsController extends AbstractController
{


    /**
     * @Route("/liste_produits", name="liste_produits")
     */
    public function listeProduits(Request $request,ProduitRepository $produitRepository, PaginatorInterface $paginator): Response
    {

        //Recherche par prix et catégorie
        $search = new PropertySearch();

        $formSearch = $this->createForm(PropertySearchType::class,$search);
        $formSearch->handleRequest($request);


        //Recherche
        //Creer une entité de recherche + formulaire + traitement dans le controlleur

        //Pagination
        //Appel du service PaginatorInterface en paramètre
        //Appel de la methode paginate + paramètres
        $pagination = $paginator->paginate(
        //On recupère tous les articles
            $produitRepository->rechecheParPrixRef($search),
            //On liste par entier (knp_paginator.yaml) on definit la cle dans url, par defaut ma page=1 + nombre d'article a afficher (ici 2)
            $request->query->getInt('page', 1), 3
        );


        //Appel de Doctrine EntityManager et ses methodes
        $entityManager = $this->getDoctrine()->getManager();
        //Stock et appel du Repository
        //Depuis entityManager on appel la methode get et on passe l'entité en paramètres
        $produitRepository = $entityManager->getRepository(Produit::class);
        //Creation de liste (Dans produit Repo on accède au methode find() findOneBy() findAll() et findBy()
        $listeProduit = $produitRepository->findBy([],['id' => 'DESC']);
        $dernierProduit = $produitRepository->getDernierProduit();
        //Appel de la vue et passage des paramètres dans un tableau associatif cle + valeur accessible depuis la vue grace a Twig
        return $this->render('liste_produits/listeProduits.html.twig', [
            //Rappel du controlleur (optionel)
            'controller_name' => 'ListeProduitsController',
            //Ici la cle (listeProduit) sera accessible dans la vue index.html.twig grace a l'interpolation {{listeProduit}} c'est un ArrayCollection
            'listeProduits' => $listeProduit,
            'dernierProduit' => $dernierProduit,
            'pagination' => $pagination,
            'form_search' => $formSearch->createView()
        ]);
    }
    /**
     * @Route("produit/{slug}/{id}", name="details_produit")
     */
    public function detailsProduit(Produit $produit):Response{

        return $this->render('liste_produits/detailsProduit.html.twig',[
            'produit' =>  $produit
        ]);
    }


    /**
     * @Route("/liste_distributeurs", name="liste_distributeurs")
     */
    public function listeDistributeur():Response{
        //Appel de Doctrine Entity Manager
        $entityManager = $this->getDoctrine()->getManager();
        //Utilsation du Distributeur Repository
        $distributeurRepository = $entityManager->getRepository(Distributeur::class);
        //Lister tous les distributeur repo->findAll()
        $distributeur = $distributeurRepository->findAll();
        //Appel de la vue
        return $this->render('liste_produits/distributeur.html.twig',[
            'distributeurs' => $distributeur
        ]);
    }




}
