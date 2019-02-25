<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Game;
use AppBundle\Entity\Platform;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto Game de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $game = new Game();
        $platform = new Platform();


        $platform->setName('Xbox');
        $game->setName('Crash Bandicoot');
        $game->setPlatform($platform);
        $game->setImage('imagen_crash.jpg');
        
        $this->assertEquals('Xbox', $game->getPlatform()->getName());
        $this->assertEquals('Crash Bandicoot', $game->getName());
        $this->assertEquals('imagen_crash.jpg', $game->getImage());
    }
}
