<?php

namespace AppBundle\Repository;

/**
 * MessageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MessageRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLastMessagesGroup($group) {
        return $query = $this->getEntityManager()
            ->createQuery(
                'SELECT m FROM AppBundle:Message m WHERE m.gameGroup = :group ORDER BY m.datetime ASC'
            )->setParameter('group', $group)
            ->setFirstResult(0)
            ->setMaxResults(50)
            ->getResult()
        ;
    }
}