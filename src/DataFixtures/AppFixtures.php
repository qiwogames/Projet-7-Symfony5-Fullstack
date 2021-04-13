<?php

namespace App\DataFixtures;

use App\Data\ListeProduits;
use App\Entity\Distributeur;
use App\Entity\Produit;
use App\Entity\Reference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Boucle de parcours des valeur du fichier src/Data/ListeProduit.php
        foreach (ListeProduits::$mesProduits as $monProduit){
            //Instance de entité (classe produit)
            $produit = new Produit();
            $reference = new Reference();
            $reference->setNumero(rand());

            //Ajout de distributeur
            $distributeur = new Distributeur();

            //Ajout des données depuis le fichier src/Data/ListeProduit.php
            $produit->setNomProduit($monProduit['nomProduit']);
            $produit->setPrixProduit($monProduit['prixProduit']);
            $produit->setQuantiteProduit($monProduit['quantiteProduit']);
            $produit->setRupture($monProduit['rupture']);
            $produit->setPhotoProduit($monProduit['photoProduit']);

            $produit->setReference($reference);
            $distributeur->setNomDistributeur($monProduit['distributeur']);
            //Pesistence des donnée grace a Doctrine ObjectManager
            $manager->persist($produit);
        }
        //Enregistrement des données
        $manager->flush();
    }
}
