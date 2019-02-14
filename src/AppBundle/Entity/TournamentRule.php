<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TournamentRule
 *
 * @ORM\Table(name="tournament_rule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TournamentRuleRepository")
 */
class TournamentRule
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
     * @ORM\Column(name="rule", type="string", length=1024)
     */
    private $rule;

    /**
     * @var Tournament
     * 
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="rules")
     * @ORM\JoinColumn(name="id_tournament", referencedColumnName="id", nullable=false)
     */
    private $tournament;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rule
     *
     * @param string $rule
     *
     * @return TournamentRule
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
    
        return $this;
    }

    /**
     * Get rule
     *
     * @return string
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Set tournament
     *
     * @param Tournament $tournament
     *
     * @return TournamentRule
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

