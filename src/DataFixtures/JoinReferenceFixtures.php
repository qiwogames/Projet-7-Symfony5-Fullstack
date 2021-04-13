<?php


namespace App\DataFixtures;


use App\Entity\Produit;
use App\Entity\Reference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class JoinReferenceFixtures extends Fixture implements ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    public function load(ObjectManager $manager)
    {
        // Appel d'entityManager
        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $repositoryProduit = $entityManager->getRepository(Produit::class);
        $listeProduits = $repositoryProduit->findAll();
        foreach ($listeProduits as $monProduit){
            $reference = new Reference();
            $reference->setNumero(rand());
            $monProduit->setReference($reference);
            $manager->persist($monProduit);
            //Pas besoin de persister $reference @ORM cascade={"persist"}
        }
        $manager->flush();
    }
}