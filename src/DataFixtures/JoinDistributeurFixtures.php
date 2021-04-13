<?php


namespace App\DataFixtures;


use App\Entity\Distributeur;
use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class JoinDistributeurFixtures extends Fixture implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $repositoryProduit = $entityManager->getRepository(Produit::class);

        //Ajout de distributeur
        $intermarche = new Distributeur();
        $intermarche->setNomDistributeur('Intermarche');

        $superu = new Distributeur();
        $superu->setNomDistributeur('Super U');

        $ldlc = new Distributeur();
        $ldlc->setNomDistributeur('LDLC');

        $thomann = new Distributeur();
        $thomann->setNomDistributeur('Thomann');

        //Les jointures : 1er produit
        $produit = $repositoryProduit->findOneBy([
            'nomProduit' => 'Imprimantes Canon'
        ]);
        $produit->addDistributeur($superu);
        $produit->addDistributeur($ldlc);
        $manager->persist($produit);

        //Second produit
        $produit = $repositoryProduit->findOneBy([
            'nomProduit' => 'Mario Bros'
        ]);
        $produit->addDistributeur($intermarche);
        $produit->addDistributeur($ldlc);
        $produit->addDistributeur($superu);
        $manager->persist($produit);

        //3ieme produit
        $produit = $repositoryProduit->findOneBy([
            'nomProduit' => 'I-phone 5'
        ]);
        $produit->addDistributeur($thomann);
        $produit->addDistributeur($ldlc);
        $produit->addDistributeur($superu);
        $manager->persist($produit);

        //4ieme produit
        $produit = $repositoryProduit->findOneBy([
            'nomProduit' => 'Table bois'
        ]);
        $produit->addDistributeur($intermarche);
        $produit->addDistributeur($superu);
        $manager->persist($produit);

        //5ieme produit
        $produit = $repositoryProduit->findOneBy([
            'nomProduit' => 'Souris Logitech'
        ]);
        $produit->addDistributeur($intermarche);
        $produit->addDistributeur($ldlc);
        $manager->persist($produit);

        //6ieme produit
        $produit = $repositoryProduit->findOneBy([
            'nomProduit' => 'Velo fille'
        ]);
        $produit->addDistributeur($intermarche);
        $produit->addDistributeur($superu);
        $manager->persist($produit);

        //7ieme produit
        $produit = $repositoryProduit->findOneBy([
            'nomProduit' => 'Casque Moto'
        ]);
        $produit->addDistributeur($thomann);
        $produit->addDistributeur($superu);
        $produit->addDistributeur($intermarche);
        $manager->persist($produit);

        //8ieme produit
        $produit = $repositoryProduit->findOneBy([
            'nomProduit' => 'Gallerie Camion'
        ]);

        $produit->addDistributeur($superu);
        $manager->persist($produit);

        //Enregistrement des fixtures
        $manager->flush();

    }
}