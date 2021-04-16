<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        //Appel de faker
        $faker = Faker\Factory::create('fr_FR');
        //Creation d'un tableau vide
        $articles = Array();
        //Boucle soit 20 elements
        for ($i = 0; $i < 20; $i++) {
            //Insatnce de entité class
            $articles[$i] = new Articles();
            //Jeu de fausse donnée
            $articles[$i]->setNomArticle($faker->word);
            $articles[$i]->setContenuArticle($faker->paragraph($nbSentences = 3, $variableNbSentences = true));
            $articles[$i]->setImageArticle("https://picsum.photos/200/300?grayscale");
            $articles[$i]->setAuteurArticle($faker->lastName);
            $articles[$i]->setDateArticle($faker->dateTime($max = 'now', $timezone = null));
            $manager->persist($articles[$i]);
        }

        $manager->flush();
    }
}
