<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

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

    public function testSearchByUsername()
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findBy(array('username'=>'Salvadoraragon'))
        ;

        $this->assertCount(1, $user);
    }

    public function testSearchByEmail()
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findBy(array('email'=>'Maria_bel@gmail.com'))
        ;

        $this->assertCount(1, $user);
    }

    public function testSearchByProfileName()
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findBy(array('profileName'=>'darkman'))
        ;

        $this->assertCount(2, $user);
    }

    public function testSearchAll()
    {
        $users = $this->entityManager
            ->getRepository(User::class)
            ->findAll();

        $this->assertCount(12, $users);
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