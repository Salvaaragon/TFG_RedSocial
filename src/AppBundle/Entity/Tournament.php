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
     * @ORM\Column(name="participants_min", type="integer")
     */
    private $participantsMin;

    /**
     * @var int
     *
     * @ORM\Column(name="participants_max", type="integer")
     */
    private $participantsMax;

    /**
     * @var string
     * 
     * @ORM\Column(name="type", type="string", length=16)
     */
    private $type;

    /**
     * @var int
     * 
     * @ORM\Column(name="match_part", type="integer")
     */
    private $participantsMatch;

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
     * Constructor
     */
    public function construct() {
        $this->rules = new ArrayCollection();
        $this->participants = new ArrayCollection();
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
     * Set participants
     *
     * @param integer $participantsMin
     *
     * @return Tournament
     */
    public function setParticipantsMin($participantsMin)
    {
        $this->participantsMin = $participantsMin;

        return $this;
    }

    /**
     * Get participantsMin
     *
     * @return int
     */
    public function getParticipantsMin()
    {
        return $this->participantsMin;
    }

    /**
     * Set participantsMax
     *
     * @param integer $participantsMax
     *
     * @return Tournament
     */
    public function setParticipantsMax($participantsMax)
    {
        $this->participantsMax = $participantsMax;

        return $this;
    }

    /**
     * Get participantsMax
     *
     * @return int
     */
    public function getParticipantsMax()
    {
        return $this->participantsMax;
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
     * Set participantsMatch
     *
     * @param integer $participantsMatch
     *
     * @return Tournament
     */
    public function setParticipantsMatch($participantsMatch)
    {
        $this->participantsMatch = $participantsMatch;

        return $this;
    }

    /**
     * Get participantsMatch
     *
     * @return int
     */
    public function getParticipantsMatch()
    {
        return $this->participantsMatch;
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
}

