<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto User de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $user = new User();

        $user->setUsername('alonso_39');
        $user->setEmail('alonso_39@gmail.com');
        $user->setProfileName('Alonso Rodríguez');
        $user->setSteamId('alonso_steam');
        $user->setXboxId('alonso_xbox');
        $user->setPsnId('alonso_playstation');
        $user->setIsActive(true);
        $user->setPlainPassword('alonso_pass');
        
        $this->assertEquals('alonso_39', $user->getUsername());
        $this->assertEquals('alonso_39@gmail.com', $user->getEmail());
        $this->assertEquals('Alonso Rodríguez', $user->getProfileName());
        $this->assertEquals('alonso_steam', $user->getSteamId());
        $this->assertEquals('alonso_xbox', $user->getXboxId());
        $this->assertEquals('alonso_playstation', $user->getPsnId());
        $this->assertEquals(true, $user->isEnabled());
        $this->assertEquals('ROLE_USER', $user->getRoles()[0]);
        $this->assertEquals('default_profile.png', $user->getImage());
        $this->assertEquals('alonso_pass', $user->getPlainPassword());
    }
}
