<?php

namespace AppBundle\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function getNumPostsUser($user) {
        return $query = $this->getEntityManager()
            ->createQuery(
                'SELECT count(p.id) FROM AppBundle:Post p WHERE p.user = :user'
            )->setParameter('user', $user)
            ->getSingleScalarResult()
        ;
    }

    public function findPostUserAndFollowing($user) {
        $query = $this->getEntityManager()
                ->createQuery(
                    'SELECT p FROM AppBundle:post p WHERE p.user = :user OR p.user in 
                        (SELECT IDENTITY(f.userFollowing) FROM AppBundle:following f WHERE f.user = :user) ORDER BY p.datetime DESC'
                )->setParameter('user',$user);

        return $query->getResult();
    }

    public function getPostsLikedByUser($user) {
        $query = $this->getEntityManager()
                ->createQuery(
                    'SELECT p FROM AppBundle:post p WHERE p.id in (SELECT IDENTITY(l.post) FROM 
                    AppBundle:postlike l WHERE l.user = :user)'
                )->setParameter('user', $user);
        
        return $query->getResult();
    }
}