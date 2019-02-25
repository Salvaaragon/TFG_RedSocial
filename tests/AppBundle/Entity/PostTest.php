<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto Post de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $post = new Post();
        $user = new User();

        $user->setUsername('ernesto_garr');
        $post->setText('Completada al fin la lista de logros de The Witcher');
        $post->setDatetime(new \Datetime('18-01-2019 20:30:55'));
        $post->setImage('thewitcher.jpg');
        $post->setUser($user);
        
        $this->assertEquals('ernesto_garr', $post->getUser()->getUsername());
        $this->assertEquals('Completada al fin la lista de logros de The Witcher', $post->getText());
        $this->assertEquals(new \Datetime('18-01-2019 20:30:55'), $post->getDatetime());
        $this->assertEquals('thewitcher.jpg', $post->getImage());
    }
}
