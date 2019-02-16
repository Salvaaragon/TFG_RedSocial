<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * TournamentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TournamentRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByPaginateTournaments($pageSize=3,$currentPage, $id_game){

        $query = $this->getEntityManager()
        ->createQueryBuilder();

        $query->select('t')
            ->from('AppBundle:Tournament', 't')
            ->where('t.game = :id_game')
            ->andWhere('t.isActive = true')
            ->orderBy('t.datetime', 'ASC')
            ->orderBy('t.type', 'DESC')
            ->setParameters(array('id_game' => $id_game))
            ->setFirstResult($pageSize * ($currentPage - 1))
            ->setMaxResults($pageSize);
 
        $paginator = new Paginator($query, $fetchJoinCollection = true);
 
        return $paginator;
    }

    public function findCountActiveTournaments($id_game, $id_platform) {
        $query = $this->getEntityManager()
        ->createQueryBuilder();

        $query->select('count(t.id) as active')
            ->from('AppBundle:Tournament', 't')
            ->leftJoin('AppBundle:Game', 'g', 'WITH', 't.game = g.id')
            ->where('t.game = :id_game')
            ->andWhere('t.isActive = true')
            ->andWhere('g.platform = :id_platform')
            ->setParameters(array('id_game' => $id_game, 'id_platform' => $id_platform));
            
        return $query->getQuery()->getSingleScalarResult();
        
    }
}