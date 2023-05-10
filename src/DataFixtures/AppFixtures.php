<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Book;
use App\Entity\Review;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $listBook = [];
        // Création d'une vingtaine de livres ayant pour titre
        for ($i = 0; $i < 20; $i++) {
            $book = new Book();
            $book->setTitle($faker->sentence(3));
            $book->setDescription($faker->text());
            // On lie le livre à un auteur pris au hasard dans le tableau des auteurs.
            $manager->persist($book);
            $listBook[] = $book;
        }


        for ($i = 0; $i < 10; $i++) {
            // Création de l'auteur lui-même.
            $review = new Review();
            $review->setRating($faker->numberBetween(1, 5));
            $review->setBody($faker->text());
         
            $review->setBook($listBook[array_rand($listBook)]);
            // On sauvegarde l'auteur créé dans un tableau.
            $manager->persist($review);
        }


        $manager->flush();
    }
}
