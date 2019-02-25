<?php

namespace Tests\AppBundle\Entity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\PostLike;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class PostLikeTest extends TestCase
{
    /**
     * Probamos que se puede crear un objeto PostLike de forma satisfactoria y dándole valores a 
     * sus parámetros
     */
    public function testCreateObject()
    {
        $postlike = new PostLike();
        $post = new Post();
        $user = new User();

        $user->setUsername('fran_chesco');
        $post->setText('Jugando Fifa en modo estrella mundial');
        $postlike->setUser($user);
        $postlike->setPost($post);
        $postlike->setDatetime(new \Datetime('01-01-2018 05:40:32'));
        
        $this->assertEquals('fran_chesco', $postlike->getUser()->getUsername());
        $this->assertEquals('Jugando Fifa en modo estrella mundial', $postlike->getPost()->getText());
        $this->assertEquals(new \Datetime('01-01-2018 05:40:32'), $postlike->getDatetime());
    }
}
