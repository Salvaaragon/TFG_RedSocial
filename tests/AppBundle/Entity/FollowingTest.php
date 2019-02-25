<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Following;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class FollowingTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto Following de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $following = new Following();
        $user = new User();
        $userFollowing = new User();

        $user->setUsername('gisela_');
        $userFollowing->setUsername('martalonso');
        $following->setUser($user);
        $following->setUserFollowing($userFollowing);
        
        $this->assertEquals('gisela_', $following->getUser()->getUsername());
        $this->assertEquals('martalonso', $following->getUserFollowing()->getUsername());
    }
}
