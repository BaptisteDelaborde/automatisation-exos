<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Film;
use App\Entity\Realisateur;
use PHPUnit\Framework\TestCase;

class RealisateurTest extends TestCase
{
    public function testGetterSetters(): void
    {
        $realisateur = new Realisateur();
        $nom = "Christopher Nolan";

        $realisateur->setNom($nom);

        $this->assertEquals($nom, $realisateur->getNom());
    }

    public function testAddRemoveFilm(): void
    {
        $realisateur = new Realisateur();
        $film = new Film();

        $realisateur->addFilm($film);
        $this->assertCount(1, $realisateur->getFilms());
        $this->assertSame($realisateur, $film->getRealisateur());

        $realisateur->removeFilm($film);
        $this->assertCount(0, $realisateur->getFilms());
        $this->assertNull($film->getRealisateur());
    }
}