<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\GameGroupVote;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GameGroupVoteRepositoryTest extends KernelTestCase
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

    public function testSearchAverageVotesUser()
    {
        $user = $this->entityManager
            ->getRepository(User::class)->findOneBy(array('username' => 'batgirl_'));
        $gamegroupvote = $this->entityManager
            ->getRepository(GameGroupVote::class)->getAverageVoteUser($user);

        $this->assertEquals(3.5, round($gamegroupvote,1));
    }

    public function testSearchBestVotedUsers()
    {
        $bestUsers = $this->entityManager
            ->getRepository(GameGroupVote::class)
            ->getBestVotedUsers(
                new \Datetime('18-01-2019 00:00:00'), new \Datetime('23-01-2019 23:59:59')
            );

        $this->assertCount(4, $bestUsers);
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