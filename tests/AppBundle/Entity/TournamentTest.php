<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Tournament;
use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class TournamentTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto Tournament de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $tournament = new Tournament();
        $game = new Game();

        $user_part_1 = new User();
        $user_part_1->setUsername('antonioHoz');

        $user_part_2 = new User();
        $user_part_2->setUsername('mariajo');

        $game->setName('For Honor');
        $tournament->setName('Torneo del jueves 10 de enero');
        $tournament->setGame($game);
        $tournament->setDatetime(new \Datetime('10-01-2019 17:00'));
        $tournament->setParticipantsRequired(8);
        $tournament->setType('eliminatoria');
        $tournament->setCurrentRound(2);
        $tournament->setWinner($user_part_2);
        $tournament->addParticipant($user_part_1);
        $tournament->addParticipant($user_part_2);
        
        $this->assertEquals('For Honor', $tournament->getGame()->getName());
        $this->assertEquals('Torneo del jueves 10 de enero', $tournament->getName());
        $this->assertEquals(new \Datetime('10-01-2019 17:00'), $tournament->getDatetime());
        $this->assertEquals(8, $tournament->getParticipantsRequired());
        $this->assertEquals('eliminatoria', $tournament->getType());
        $this->assertEquals(2, $tournament->getCurrentRound());
        $this->assertEquals(true, $tournament->getIsActive());
        $this->assertEquals('mariajo', $tournament->getWinner()->getUsername());
        $this->assertEquals('antonioHoz', $tournament->getParticipants()->get(0)->getUsername());
        $this->assertEquals('mariajo', $tournament->getParticipants()->get(1)->getUsername());
    }
}
