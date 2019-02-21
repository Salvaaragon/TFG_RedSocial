<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GameGroupVote
 *
 * @ORM\Table(name="game_group_vote")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GameGroupVoteRepository")
 */
class GameGroupVote
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
     * @ORM\JoinColumn(name="id_user_voted", referencedColumnName="id")
     */
    private $userVoted;

    /**
     * @var GameGroup
     * 
     * @ORM\ManyToOne(targetEntity="GameGroup")
     * @ORM\JoinColumn(name="id_game_group", referencedColumnName="id", unique=false)
     */
    private $gameGroup;

    /**
     * @var int
     * 
     * @ORM\Column(name="vote", type="integer")
     */
    private $vote;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;


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
     * @return GameGroupVote
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
     * Set userVoted
     * 
     * @param User $user
     * 
     * @return GameGroupVote
     */
    public function setUserVoted($userVoted) {
        $this->userVoted = $userVoted;

        return $this;
    }

    /**
     * Get userVoted
     * 
     * @return User
     */
    public function getUserVoted() {
        return $this->userVoted;
    }

    /**
     * Set gameGroup
     * 
     * @return GameGroupVote
     */
    public function setGameGroup($gameGroup) {
        $this->gameGroup = $gameGroup;

        return $this;
    }

    /**
     * Get gameGroup
     * 
     * @return GameGroup
     */
    public function getGameGroup() {
        return $this->gameGroup;
    }

    /**
     * Set vote
     * 
     * @return GameGroupVote
     */
    public function setVote($vote) {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     * 
     * @return int
     */
    public function getVote() {
        return $this->vote;
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

}

