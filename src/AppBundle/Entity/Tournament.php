<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * tournament
 *
 * @ORM\Table(name="tournament")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TournamentRepository")
 */
class Tournament
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
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var Game
     *
     * @ORM\ManyToOne(targetEntity="Game")
     * @ORM\JoinColumn(name="id_game", referencedColumnName="id", nullable=false)
     */
    private $game;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var int
     *
     * @ORM\Column(name="participants_required", type="integer")
     */
    private $participantsRequired;

    /**
     * @var string
     * 
     * @ORM\Column(name="type", type="string", length=16)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="TournamentRule", mappedBy="tournament")
     */
    private $rules;
    
    /**
     * @ORM\OneToMany(targetEntity="TournamentPairing", mappedBy="tournament")
     */
    private $pairings;

    /**
     * @var int
     * 
     * @ORM\Column(name="current_round", type="integer")
     */
    private $currentRound;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_winner", referencedColumnName="id", nullable=true)
     */
    private $winner;

    /**
     * 
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="tournament_participants",
     *      joinColumns={@ORM\JoinColumn(name="id_tournament", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_user", referencedColumnName="id")}
     *      )
     */
    private $participants;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * Constructor
     */
    public function __construct() {
        $this->rules = new ArrayCollection();
        $this->participants = new ArrayCollection();
        $this->setIsActive(true);
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
     * Set name
     *
     * @param string $name
     *
     * @return Tournament
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set game
     *
     * @param Game $game
     *
     * @return Tournament
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * Get game
     *
     * @return Game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Tournament
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
     * Set participantsRequired
     *
     * @param integer $participantsRequired
     *
     * @return Tournament
     */
    public function setParticipantsRequired($participantsRequired)
    {
        $this->participantsRequired = $participantsRequired;

        return $this;
    }

    /**
     * Get participantsRequired
     *
     * @return int
     */
    public function getParticipantsRequired()
    {
        return $this->participantsRequired;
    }

    /**
     * Set type
     * 
     * @param string $type
     * 
     * @return Tournament
     */
    public function setType($type) 
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     * 
     * @return string
     */
    public function getType() 
    {
        return $this->type;
    }

    /**
     * Set currentRound
     * 
     * @param integer $currentRound
     * 
     * @return Tournament
     */
    public function setCurrentRound($currentRound) {
        $this->currentRound = $currentRound;
        return $this;
    }

    /**
     * Get currentRound
     * 
     * @return int
     */
    public function getCurrentRound() {
        return $this->currentRound;
    }

    /**
     * Add Participant to tournament
     * 
     * @param User $user
     * 
     * @return Tournament
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

    /**
     * Set winner
     *
     * @param User $winner
     *
     * @return Tournament
     */
    public function setWinner(?User $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get winner
     *
     * @return User
     */
    public function getWinner(): ?User
    {
        return $this->winner;
    }

    /**
     * Set isActive
     * 
     * @param boolean $isActive
     * 
     * @return Tournament
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
}

