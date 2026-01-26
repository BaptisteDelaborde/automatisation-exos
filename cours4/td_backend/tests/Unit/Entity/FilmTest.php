<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Film;
use App\Entity\Realisateur;
use PHPUnit\Framework\TestCase;

class FilmTest extends TestCase
{
    public function testGetterSetters(): void
    {
        $film = new Film();
        $titre = "Interstellar";
        $annee = 2014;
        $duree = 169;

        $film->setTitre($titre)
            ->setAnnee($annee)
            ->setDuree($duree);

        $this->assertEquals($titre, $film->getTitre());
        $this->assertEquals($annee, $film->getAnnee());
        $this->assertEquals($duree, $film->getDuree());
    }

    public function testRelationRealisateur(): void
    {
        $film = new Film();
        $realisateur = new Realisateur();

        $film->setRealisateur($realisateur);
        $this->assertSame($realisateur, $film->getRealisateur());
    }
}