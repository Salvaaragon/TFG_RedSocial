<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Platform;
use PHPUnit\Framework\TestCase;

class PlatformTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto Platform de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $platform = new Platform();

        $platform->setName('PlayStation');
        
        $this->assertEquals('PlayStation', $platform->getName());
    }
}
