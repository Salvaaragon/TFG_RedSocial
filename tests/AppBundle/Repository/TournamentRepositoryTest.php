<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Tournament;
use AppBundle\Entity\Game;
use AppBundle\Entity\Platform;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TournamentRepositoryTest extends KernelTestCase
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

    public function testSearchActiveByGame() {
        $platform = $this->entityManager
            ->getRepository(Platform::class)->findOneBy(array('name'=>'Xbox'));

        $game = $this->entityManager
            ->getRepository(Game::class)
            ->findOneBy(
                array(
                    'name' => 'Assassin\'s_Creed_Origins',
                    'platform' => $platform));

        $tournaments = $this->entityManager
            ->getRepository(Tournament::class)
            ->findCountActiveTournaments($game->getId(), $platform->getId());

        $this->assertEquals(1,$tournaments);
    }

    public function testSearchMostWinnersInterval() {
        $tournamentsWinners = $this->entityManager
            ->getRepository(Tournament::class)
            ->getMostTournamentsWinners(
                new \Datetime('2019-01-10 00:00:00'), new \Datetime('2019-02-23 23:59:59'));
        
        $mostWinnerUser = $tournamentsWinners[0];
        $user = $this->entityManager->getRepository(User::class)->find($mostWinnerUser['id_user']);
        $num_wins = $mostWinnerUser['total'];

        $this->assertEquals('whynot45',$user->getUsername());
        $this->assertEquals(3, $num_wins);
        $this->assertCount(7,$tournamentsWinners);
    }

    public function testSearchAll()
    {
        $tournaments = $this->entityManager
            ->getRepository(Tournament::class)
            ->findAll();

        $this->assertCount(15, $tournaments);
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