<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Model\Personne;
$faker = Faker\Factory::create('fr_FR');
$personne = new Personne();
$personne->setPrenom($faker->firstName());
$personne->setNom($faker->lastName());
$personne->setAge($faker->numberBetween(18, 80));
$personne->setAdresse('1 rue de la Paix');
$personne->setVille('Paris');
$personne->setCodePostal('75000');
$personne->setEmail('albert.mudha@monmail.fr');
$personne->setTelephone('0123456789');
$personne->setProfession('Testeur');

require_once __DIR__ . '/../src/View/affichage.php';
