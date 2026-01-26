<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Realisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FilmFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $realisateurs = [];

        // Création de 5 réalisateurs
        for ($i = 0; $i < 5; $i++) {
            $realisateur = new Realisateur();
            $realisateur->setNom($faker->name);

            $manager->persist($realisateur);
            $realisateurs[] = $realisateur;
        }

        // Création de 15 films liés à des réalisateurs
        for ($i = 0; $i < 15; $i++) {
            $film = new Film();
            $film->setTitre($faker->sentence(3));
            $film->setAnnee($faker->numberBetween(1980, 2024));
            $film->setDuree($faker->numberBetween(80, 180));
            $film->setRealisateur(
                $faker->randomElement($realisateurs)
            );

            $manager->persist($film);
        }

        $manager->flush();
    }
}
