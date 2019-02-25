<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\GameGroup;
use AppBundle\Entity\GameGroupVote;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class GameGroupVoteTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto GameGroupVote de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $gamegroupvote = new GameGroupVote();
        $gamegroup = new GameGroup();
        $user = new User();
        $userVoted = new User();

        $user->setUsername('Costantine');
        $userVoted->setUsername('Carolina_');
        $gamegroup->setGame('Metal Gear: The Phantom Pain');
        $gamegroupvote->setUser($user);
        $gamegroupvote->setUserVoted($userVoted);
        $gamegroupvote->setGameGroup($gamegroup);
        $gamegroupvote->setVote(3);
        $gamegroupvote->setDatetime(new \Datetime('25-02-2019 20:30'));
        
        $this->assertEquals('Costantine', $gamegroupvote->getUser()->getUsername());
        $this->assertEquals('Carolina_', $gamegroupvote->getUserVoted()->getUsername());
        $this->assertEquals('Metal Gear: The Phantom Pain', $gamegroupvote->getGameGroup()->getGame());
        $this->assertEquals(3, $gamegroupvote->getVote());
        $this->assertEquals(new \Datetime('25-02-2019 20:30'), $gamegroupvote->getDatetime());
    }
}
