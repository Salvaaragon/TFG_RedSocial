<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\GameGroup;
use AppBundle\Entity\Platform;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class GameGroupTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto GameGroup de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $gamegroup = new GameGroup();
        $platform = new Platform();
        $user = new User();

        $user_part_1 = new User();
        $user_part_1->setUsername('susana_48');

        $user_part_2 = new User();
        $user_part_2->setUsername('jesus_gamer');

        $platform->setName('Steam');
        $user->setUsername('miguel92');
        $gamegroup->setGame('Rocket League');
        $gamegroup->setPlatform($platform);
        $gamegroup->setUser($user);
        $gamegroup->setDatetime(new \Datetime('26-12-2018 18:45'));
        $gamegroup->setMaxParticipants(2);
        $gamegroup->addParticipant($user_part_1);
        $gamegroup->addParticipant($user_part_2);
        
        $this->assertEquals('Steam', $gamegroup->getPlatform()->getName());
        $this->assertEquals('miguel92', $gamegroup->getUser()->getUsername());
        $this->assertEquals('Rocket League', $gamegroup->getGame());
        $this->assertEquals(2, $gamegroup->getMaxParticipants());
        $this->assertEquals('susana_48', $gamegroup->getParticipants()->get(0)->getUsername());
        $this->assertEquals('jesus_gamer', $gamegroup->getParticipants()->get(1)->getUsername());
    }
}
