<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Tournament;
use AppBundle\Entity\TournamentPairing;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class TournamentPairingTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto TournamentPairing de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $tournamentpairing = new TournamentPairing();
        $tournament = new Tournament();
        $user_player_one = new User();
        $user_player_two = new User();

        $tournament->setName('Torneo martes 5 de febrero');
        $user_player_one->setEmail('correodeantonio@gmail.com');
        $user_player_two->setEmail('madmax28@outlook.es');
        $tournamentpairing->setTournament($tournament);
        $tournamentpairing->setPlayerOne($user_player_one);
        $tournamentpairing->setPlayerTwo($user_player_two);
        $tournamentpairing->setImageResultPlayerOne('resultado_1.png');
        $tournamentpairing->setImageResultPlayerTwo('resultado_2.png');
        $tournamentpairing->setResultPlayerOne('antonio_fdez');
        $tournamentpairing->setResultPlayerTwo('antonio_fdez');
        $tournamentpairing->setWinner($user_player_one);
        $tournamentpairing->setRound(3);
        
        $this->assertEquals('Torneo martes 5 de febrero', $tournamentpairing->getTournament()->getName());
        $this->assertEquals('correodeantonio@gmail.com', $tournamentpairing->getPlayerOne()->getEmail());
        $this->assertEquals('madmax28@outlook.es', $tournamentpairing->getPlayerTwo()->getEmail());
        $this->assertEquals('resultado_1.png', $tournamentpairing->getImageResultPlayerOne());
        $this->assertEquals('resultado_2.png', $tournamentpairing->getImageResultPlayerTwo());
        $this->assertEquals('antonio_fdez', $tournamentpairing->getResultPlayerOne());
        $this->assertEquals('antonio_fdez', $tournamentpairing->getResultPlayerTwo());
        $this->assertEquals('correodeantonio@gmail.com', $tournamentpairing->getWinner()->getEmail());
        $this->assertEquals(3, $tournamentpairing->getRound());
    }
}
