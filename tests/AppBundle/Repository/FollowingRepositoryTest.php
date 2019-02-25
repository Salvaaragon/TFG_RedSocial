<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Following;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FollowingRepositoryTest extends KernelTestCase
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

    public function testSearchNumFollowingsUser()
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(array('username' => 'Maria_bel'));
        $numFollowings = $this->entityManager
            ->getRepository(Following::class)
            ->getNumFollowingsUser($user);

        $this->assertEquals(9, $numFollowings);
    }

    public function testSearchNumFollowersUser()
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(array('username' => 'hugo178'));
        $numFollowers = $this->entityManager
            ->getRepository(Following::class)
            ->getNumFollowersUser($user);

        $this->assertEquals(9, $numFollowers);
    }

    public function testSearchFollowingsUser()
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(array('username' => 'darkman'));
        $followings = $this->entityManager
            ->getRepository(Following::class)
            ->findFollowingsUser($user);

        $this->assertCount(9, $followings);
    }

    public function testSearchFollowersUser()
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(array('username' => 'Salvadoraragon'));
        $followers = $this->entityManager
            ->getRepository(Following::class)
            ->findFollowersUser($user);

        $this->assertCount(9, $followers);
    }

    public function testSearchUserFollowUser()
    {
        $user_1 = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(array('username' => 'whynot45'));
        $user_2 = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(array('username' => 'hugo178'));
        $isFollowed = $this->entityManager
            ->getRepository(Following::class)
            ->getUserIsFollowing($user_1, $user_2);

        $this->assertEquals('followed', $isFollowed);
    }

    public function testSearchUserNotFollowUser()
    {
        $user_1 = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(array('username' => 'jenifer_lop'));
        $user_2 = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(array('username' => 'Salvadoraragon'));
        $isFollowed = $this->entityManager
            ->getRepository(Following::class)
            ->getUserIsFollowing($user_1, $user_2);

        $this->assertEquals('unfollowed', $isFollowed);
    }

    public function testSearchAll()
    {
        $followings = $this->entityManager
            ->getRepository(Following::class)
            ->findAll();

        $this->assertCount(90, $followings);
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