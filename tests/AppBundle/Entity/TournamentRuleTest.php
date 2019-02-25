<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Tournament;
use AppBundle\Entity\TournamentRule;
use PHPUnit\Framework\TestCase;

class TournamentRuleTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto TournamentRule de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $tournamentrule = new TournamentRule();
        $tournament = new Tournament();

        $tournament->setName('Torneo lunes 11 de febrero');
        $tournamentrule->setTournament($tournament);
        $tournamentrule->setRule('Prohibido usar múltiples cuentas');
        
        $this->assertEquals('Torneo lunes 11 de febrero', $tournamentrule->getTournament()->getName());
        $this->assertEquals('Prohibido usar múltiples cuentas', $tournamentrule->getRule());

    }
}
