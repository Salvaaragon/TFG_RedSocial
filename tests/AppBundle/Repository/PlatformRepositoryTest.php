<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Platform;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PlatformRepositoryTest extends KernelTestCase
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

    public function testSearchByName()
    {
        $platform = $this->entityManager
            ->getRepository(Platform::class)
            ->findBy(array('name'=>'PlayStation'));

        $this->assertCount(1, $platform);
    }

    public function testSearchAll()
    {
        $platforms = $this->entityManager
            ->getRepository(Platform::class)
            ->findAll();

        $this->assertCount(3, $platforms);
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