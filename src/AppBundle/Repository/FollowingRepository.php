<?php

namespace AppBundle\Repository;

/**
 * FollowingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FollowingRepository extends \Doctrine\ORM\EntityRepository
{
    public function getNumFollowingsUser($user) {
        return $query = $this->getEntityManager()
            ->createQuery(
                'SELECT count(f.id) FROM AppBundle:Following f WHERE f.user = :user'
            )->setParameter('user', $user)
            ->getSingleScalarResult()
        ;
    }

    public function getNumFollowersUser($user) {
        return $query = $this->getEntityManager()
            ->createQuery(
                'SELECT count(f.id) FROM AppBundle:Following f WHERE f.userFollowing = :user'
            )->setParameter('user', $user)
            ->getSingleScalarResult()
        ;
    }

    public function findFollowersUser($user) {
        return $query = $this->getEntityManager()
            ->createQuery(
                'SELECT IDENTITY(f.user) as id_user FROM AppBundle:Following f WHERE f.userFollowing = :user'
            )->setParameter('user', $user)
            ->getResult();
        ;
    }

    public function findFollowingsUser($user) {
        return $query = $this->getEntityManager()
            ->createQuery(
                'SELECT IDENTITY(f.userFollowing) as id_user FROM AppBundle:Following f WHERE f.user = :user'
            )->setParameter('user', $user)
            ->getResult();
        ;
    }

    public function getUserIsFollowing($user, $follower_user) {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT count(f.id) FROM AppBundle:Following f WHERE f.user = :user 
                and f.userFollowing = :follower_user'
            )->setParameters(array('user' => $user, 'follower_user' => $follower_user))
            ->getSingleScalarResult();

        if($query == 1) return 'followed';
        else return 'unfollowed';
    }
}