<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\PostLike;
use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostLikeRepositoryTest extends KernelTestCase
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

    public function testSearchNumLikesPost()
    {
        $user = $this->entityManager
            ->getRepository(User::class)->findBy(array('username' => 'teresa_yo'));
        $post = $this->entityManager
            ->getRepository(Post::class)->findOneBy(
                array(
                    'user' => $user, 
                    'datetime' => new \Datetime('2019-02-17 20:30:40')
                )
            );

        $numLikes = $this->entityManager
            ->getRepository(PostLike::class)
            ->getNumLikesPost($post);

        $this->assertEquals(8, $numLikes);
    }

    public function testSearchUserHasLikePost()
    {
        $user_1 = $this->entityManager
            ->getRepository(User::class)->findBy(array('username' => 'teresa_yo'));
        $user_2 = $this->entityManager
            ->getRepository(User::class)->findBy(array('username' => 'batgirl_'));
        $post = $this->entityManager
            ->getRepository(Post::class)->findOneBy(
                array(
                    'user' => $user_1, 
                    'datetime' => new \Datetime('2019-02-17 20:30:40')
                )
            );

        $hasLiked = $this->entityManager
            ->getRepository(PostLike::class)
            ->getUserHasLikePost($post, $user_2);

        $this->assertEquals('liked', $hasLiked);
    }

    public function testSearchUserHasNotLikePost()
    {
        $user_1 = $this->entityManager
            ->getRepository(User::class)->findBy(array('username' => 'whynot45'));
        $user_2 = $this->entityManager
            ->getRepository(User::class)->findBy(array('username' => 'jenifer_lop'));
        $post = $this->entityManager
            ->getRepository(Post::class)->findOneBy(
                array(
                    'user' => $user_1, 
                    'datetime' => new \Datetime('2019-01-30 16:01:04')
                )
            );

        $hasLiked = $this->entityManager
            ->getRepository(PostLike::class)
            ->getUserHasLikePost($post, $user_2);

        $this->assertEquals('unliked', $hasLiked);
    }

    public function testSearchNumPostsLikedByUser() {
        $user = $this->entityManager
            ->getRepository(User::class)->findOneBy(array('username' =>'ernestoal'));
        $numPosts = $this->entityManager
            ->getRepository(PostLike::class)
            ->getNumPostUserHasLiked($user);

        $this->assertEquals(8, $numPosts);
    }

    public function testSearchBestPostsInterval() {
        $bestposts = $this->entityManager
            ->getRepository(PostLike::class)
            ->getBestPosts(new \Datetime('19-02-2019 00:00:00'), new \Datetime('24-02-2019 23:59:59'));

        $this->assertCount(3, $bestposts);
    }

    public function testSearchAll()
    {
        $postlikes = $this->entityManager
            ->getRepository(PostLike::class)
            ->findAll();

        $this->assertCount(15, $postlikes);
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