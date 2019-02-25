<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\GameGroup;
use AppBundle\Entity\User;
use AppBundle\Entity\Platform;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GameGroupRepositoryTest extends KernelTestCase
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

    public function testSearchGroupsUserActives()
    {
        $user = $this->entityManager
            ->getRepository(User::class)->findBy(array('username' => 'batgirl_'));
        $gamegroup = $this->entityManager
            ->getRepository(GameGroup::class)->getNumGroupsUser($user);

        $this->assertEquals(1, $gamegroup);
    }

    public function testSearchGroupsActiveNotPlaying()
    {
        $gamegroups = $this->entityManager
            ->getRepository(GameGroup::class)->getAllGroupsActiveNotPlaying();

        $this->assertCount(0, $gamegroups);
    }

    public function testSearchGroupsNotActiveForUserAndPlatform()
    {
        $user = $this->entityManager
            ->getRepository(User::class)->findOneBy(array('username' => 'susana_23'));
        $platform = $this->entityManager
            ->getRepository(Platform::class)->findOneBy(array('name' => 'PlayStation'));
        $gamegroups = $this->entityManager
            ->getRepository(GameGroup::class)
            ->getAllGroupsPlatformUser($platform->getId(), $user->getId());

        $this->assertCount(2, $gamegroups);
    }

    public function testSearchGroupsNotActiveForUser()
    {
        $user = $this->entityManager
            ->getRepository(User::class)->findOneBy(array('username' => 'hugo178'));
        $gamegroups = $this->entityManager
            ->getRepository(GameGroup::class)
            ->getAllGroupsUser($user->getId());

        $this->assertCount(3, $gamegroups);
    }

    public function testSearchGroupsNotActiveForUserParticipantAndPlatform()
    {
        $user = $this->entityManager
            ->getRepository(User::class)->findOneBy(array('username' => 'miguelangel'));
        $platform = $this->entityManager
            ->getRepository(Platform::class)->findOneBy(array('name' => 'PlayStation'));
        $gamegroups = $this->entityManager
            ->getRepository(GameGroup::class)
            ->getAllPartPlatformUser($platform->getId(), $user->getId());

        $this->assertCount(4, $gamegroups);
    }

    public function testSearchGroupsNotActiveForUserParticipant()
    {
        $user = $this->entityManager
            ->getRepository(User::class)->findOneBy(array('username' => 'teresa_yo'));
        $gamegroups = $this->entityManager
            ->getRepository(GameGroup::class)
            ->getAllPartUser($user->getId());

        $this->assertCount(7, $gamegroups);
    }

    public function testSearchGroupsActiveForPlatform()
    {
        $platform = $this->entityManager
            ->getRepository(Platform::class)->findOneBy(array('name' => 'PlayStation'));
        $gamegroups = $this->entityManager
            ->getRepository(GameGroup::class)
            ->getAllGroupsPlayingPlatform($platform->getId());

        $this->assertCount(3, $gamegroups);
    }

    public function testSearchGroupsActive()
    {
        $gamegroups = $this->entityManager
            ->getRepository(GameGroup::class)
            ->getAllGroupsPlaying();

        $this->assertCount(4, $gamegroups);
    }

    public function testSearchAll()
    {
        $gamegroups = $this->entityManager
            ->getRepository(GameGroup::class)
            ->findAll();

        $this->assertCount(30, $gamegroups);
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