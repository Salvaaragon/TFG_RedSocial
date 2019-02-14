<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * TournamentPairing
 *
 * @ORM\Table(name="tournament_pairing")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TournamentPairingRepository")
 */
class TournamentPairing
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
     * @ORM\JoinColumn(name="id_player_one", referencedColumnName="id", nullable=false)
     */
    private $playerOne;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_player_two", referencedColumnName="id", nullable=false)
     */
    private $playerTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="image_result_player_one", type="string", length=255, nullable=true)
     */
    private $imageResultPlayerOne;

    /**
     * @var string
     *
     * @ORM\Column(name="image_result_player_two", type="string", length=255, nullable=true)
     */
    private $imageResultPlayerTwo;

    /**
     * @var string
     * 
     * @ORM\Column(name="result_player_one", type="string", length=255, nullable=true)
     */
    private $resultPlayerOne;

        /**
     * @var string
     * 
     * @ORM\Column(name="result_player_two", type="string", length=255, nullable=true)
     */
    private $resultPlayerTwo;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_winner", referencedColumnName="id", nullable=true)
     */
    private $winner;

    /**
     * @var int
     * 
     * @ORM\Column(name="round", type="integer")
     */
    private $round;
    
    /**
     * @var Tournament
     * 
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="pairings")
     * @ORM\JoinColumn(name="id_tournament", referencedColumnName="id", nullable=false)
     */
    private $tournament;

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
     * Set playerOne
     *
     * @param User $playerOne
     *
     * @return TournamentPairing
     */
    public function setPlayerOne(?User $playerOne): self
    {
        $this->playerOne = $playerOne;

        return $this;
    }

    /**
     * Get playerOne
     *
     * @return User
     */
    public function getPlayerOne(): ?User
    {
        return $this->playerOne;
    }

    /**
     * Set playerTwo
     *
     * @param User $playerTwo
     *
     * @return TournamentPairing
     */
    public function setPlayerTwo(?User $playerTwo): self
    {
        $this->playerTwo = $playerTwo;

        return $this;
    }

    /**
     * Get playerTwo
     *
     * @return User
     */
    public function getPlayerTwo(): ?User
    {
        return $this->playerTwo;
    }

    /**
     * Set imageResultPlayerOne
     *
     * @param string $imageResultPlayerOne
     *
     * @return TournamentPairing
     */
    public function setImageResultPlayerOne($imageResultPlayerOne)
    {
        $this->imageResultPlayerOne = $imageResultPlayerOne;

        return $this;
    }

    /**
     * Get imageResultPlayerOne
     *
     * @return string
     */
    public function getImageResultPlayerOne()
    {
        return $this->imageResultPlayerOne;
    }

    /**
     * Set imageResultPlayerTwo
     *
     * @param string $imageResultPlayerTwo
     *
     * @return TournamentPairing
     */
    public function setImageResultPlayerTwo($imageResultPlayerTwo)
    {
        $this->imageResultPlayerTwo = $imageResultPlayerTwo;

        return $this;
    }

    /**
     * Get imageResultPlayerTwo
     *
     * @return string
     */
    public function getImageResultPlayerTwo()
    {
        return $this->imageResultPlayerTwo;
    }

    /**
     * Set resultPlayerOne
     *
     * @param string $resultPlayerOne
     *
     * @return TournamentPairing
     */
    public function setResultPlayerOne($resultPlayerOne)
    {
        $this->resultPlayerOne = $resultPlayerOne;

        return $this;
    }

    /**
     * Get resultPlayerOne
     *
     * @return string
     */
    public function getResultPlayerOne()
    {
        return $this->resultPlayerOne;
    }

    /**
     * Set resultPlayerTwo
     *
     * @param string $resultPlayerTwo
     *
     * @return TournamentPairing
     */
    public function setResultPlayerTwo($resultPlayerTwo)
    {
        $this->resultPlayerTwo = $resultPlayerTwo;

        return $this;
    }

    /**
     * Get resultPlayerTwo
     *
     * @return string
     */
    public function getResultPlayerTwo()
    {
        return $this->resultPlayerTwo;
    }

    /**
     * Set winner
     *
     * @param User $winner
     *
     * @return TournamentPairing
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
     * Set round
     * 
     * @param int $round
     *
     * @return TournamentPairing
     */
    public function setRound($round)
    {
        $this->round = $round;

        return $this;
    }

    /**
     * Get round
     * 
     * @return int
     */
    public function getRound() 
    {
        return $this->round;
    }


    /**
     * Set tournament
     *
     * @param Tournament $tournament
     *
     * @return TournamentPairing
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;

        return $this;
    }

    /**
     * Get tournament
     *
     * @return Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

   
}

