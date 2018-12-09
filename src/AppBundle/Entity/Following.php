<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Following
 *
 * @ORM\Table(name="following")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FollowingRepository")
 */
class Following
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_user_following", referencedColumnName="id")
     */
    private $userFollowing;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Following
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user_following
     * 
     * @param User $user
     * 
     * @return Following
     */
    public function setUserFollowing($userFollowing) {
        $this->userFollowing = $userFollowing;

        return $this;
    }

    /**
     * Get userFollowing
     * 
     * @return User
     */
    public function getUserFollowing() {
        return $this->userFollowing;
    }
}

