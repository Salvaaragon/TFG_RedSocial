<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $encoder;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchAllForUser()
    {
        $user = $this->entityManager
            ->getRepository(User::class)->findOneBy(array('username' =>'teresa_yo'));
        $numPosts = $this->entityManager
            ->getRepository(Post::class)
            ->getNumPostsUser($user);

        $this->assertEquals(4, $numPosts);
    }

    public function testSearchPostsLikedByUser() {
        $user = $this->entityManager
            ->getRepository(User::class)->findOneBy(array('username' =>'ernestoal'));
        $posts = $this->entityManager
            ->getRepository(Post::class)
            ->getPostsLikedByUser($user);

        $this->assertCount(8, $posts);
    }

    public function testSearchAll()
    {
        $posts = $this->entityManager
            ->getRepository(Post::class)
            ->findAll();

        $this->assertCount(20, $posts);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}