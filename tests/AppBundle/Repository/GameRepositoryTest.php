<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Game;
use AppBundle\Entity\Platform;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GameRepositoryTest extends KernelTestCase
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

    public function testSearchByPlatform()
    {
        $platform = $this->entityManager
            ->getRepository(Platform::class)
            ->findOneBy(array('name'=>'Steam'));
        $game = $this->entityManager
            ->getRepository(Game::class)
            ->findBy(array('platform'=> $platform));

        $this->assertCount(3, $game);
    }

    public function testSearchByName()
    {
        $game = $this->entityManager
            ->getRepository(Game::class)
            ->findBy(array('name'=>'Monster_Hunter:_World'));

        $this->assertCount(1, $game);
    }

    public function testSearchAll()
    {
        $games = $this->entityManager
            ->getRepository(Game::class)
            ->findAll();

        $this->assertCount(9, $games);
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