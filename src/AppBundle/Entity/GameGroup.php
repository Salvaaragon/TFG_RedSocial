<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * GameGroup
 *
 * @ORM\Table(name="game_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameGroupRepository")
 */
class GameGroup
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
     * @var string
     *
     * @ORM\Column(name="game", type="string", length=128)
     */
    private $game;

    /**
     * @var Platform
     *
     * @ORM\ManyToOne(targetEntity="Platform", inversedBy="game_groups")
     * @ORM\JoinColumn(name="id_platform", referencedColumnName="id", nullable=false)
     */
    private $platform;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="game_groups")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var int
     *
     * @ORM\Column(name="max_participants", type="integer")
     */
    private $maxParticipants;

    /**
    * @ORM\OneToMany(targetEntity="Message", mappedBy="gameGroup")
    */
    private $messages;

    /**
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * 
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="groups_users",
     *      joinColumns={@ORM\JoinColumn(name="id_group", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_user", referencedColumnName="id", unique=true)}
     *      )
     */
    private $participants;

    /**
    * Constructor
    */
    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->isActive = true;
    }

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
     * Set game
     *
     * @param string $game
     *
     * @return GameGroup
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return string
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set platform
     *
     * @param Platform $platform
     *
     * @return GameGroup
     */
    public function setPlatform(?Platform $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * Get platform
     *
     * @return Platform
     */
    public function getPlatform(): ?Platform
    {
        return $this->platform;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return GameGroup
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set datetime
     * 
     * @param \DateTime $datetime
     *
     * @return GameGroup
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set maxParticipants
     *
     * @param integer $maxParticipants
     *
     * @return GameGroup
     */
    public function setMaxParticipants($maxParticipants)
    {
        $this->maxParticipants = $maxParticipants;

        return $this;
    }

    /**
     * Get maxParticipants
     *
     * @return int
     */
    public function getMaxParticipants()
    {
        return $this->maxParticipants;
    }

    /**
     * Set isActive
     * 
     * @param boolean $isActive
     * 
     * @return GameGroup
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     * 
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add Participant to group
     * 
     * @param User $user
     * 
     * @return GameGroup
     */
    public function addParticipant($user)
    {
        $this->participants->add($user);
    }

    /**
     * Get participants
     * 
     * @return ArrayCollection
     */
    public function getParticipants()
    {
        return $this->participants;
    }
}

