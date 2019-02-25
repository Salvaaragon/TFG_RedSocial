<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Message;
use AppBundle\Entity\GameGroup;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto Message de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $message = new Message();
        $gamegroup = new GameGroup();
        $user = new User();

        $user->setUsername('joseluis_27');
        $gamegroup->setGame('Apex Legends');
        $message->setUser($user);
        $message->setGameGroup($gamegroup);
        $message->setDatetime(new \Datetime('04-11-2018 08:56:32'));
        $message->setMessage('No puedo jugar hasta las 9 y media');
        
        $this->assertEquals('joseluis_27', $message->getUser()->getUsername());
        $this->assertEquals('Apex Legends', $message->getGameGroup()->getGame());
        $this->assertEquals(new \Datetime('04-11-2018 08:56:32'), $message->getDatetime());
        $this->assertEquals('No puedo jugar hasta las 9 y media', $message->getMessage());
    }
}
