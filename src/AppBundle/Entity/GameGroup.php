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
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hour", type="time")
     */
    private $hour;

    /**
     * @var int
     *
     * @ORM\Column(name="max_participants", type="integer")
     */
    private $maxParticipants;

    /**
    * @ORM\OneToMany(targetEntity="Message", mappedBy="gamegroup")
    */
    private $messages;


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
     * Set idUserCreator
     *
     * @param integer $idUserCreator
     *
     * @return GameGroup
     */
    public function setIdUserCreator($idUserCreator)
    {
        $this->idUserCreator = $idUserCreator;

        return $this;
    }

    /**
     * Get idUserCreator
     *
     * @return int
     */
    public function getIdUserCreator()
    {
        return $this->idUserCreator;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return GameGroup
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set hour
     *
     * @param \DateTime $hour
     *
     * @return GameGroup
     */
    public function setHour($hour)
    {
        $this->hour = $hour;

        return $this;
    }

    /**
     * Get hour
     *
     * @return \DateTime
     */
    public function getHour()
    {
        return $this->hour;
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
}

