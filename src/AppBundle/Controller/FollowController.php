<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;
use AppBundle\Entity\PostLike;
use AppBundle\Entity\Following;
use AppBundle\Entity\User;
use AppBundle\Form\PostType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;

class FollowController extends Controller
{
    /**
     * @Route("/follow/{id_user}/{id_follower}", name="follow_user", options={"expose"=true})
     */
    public function followAction($id_user, $id_follower) {
 
        $repository_following = $this->getDoctrine()->getRepository(Following::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);

        if($id_user != $id_follower) {
            $user = $repository_user->findOneBy(array('id' => $id_user));
            $followUser = $repository_user->findOneBy(array('id' => $id_follower));

            if(isset($user) && isset($followUser)) {
                $following = $repository_following->findOneBy(array(
                    'user' => $user, 'userFollowing' => $followUser));
    
                if(!isset($following)) {
                    $following = new Following();
                    $following->setUser($user);
                    $following->setUserFollowing($followUser);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($following);
                    $entityManager->flush();

                    return new Response();
                }
            }
        }
    }

    /**
     * @Route("/unfollow/{id_user}/{id_follower}", name="unfollow_user", options={"expose"=true})
     */
    public function unfollowAction($id_user, $id_follower) {
 
        $repository_following = $this->getDoctrine()->getRepository(Following::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);

        if($id_user != $id_follower) {
            $user = $repository_user->findOneBy(array('id' => $id_user));
            $unfollowUser = $repository_user->findOneBy(array('id' => $id_follower));

            if(isset($user) && isset($unfollowUser)) {
                $following = $repository_following->findOneBy(array(
                    'user' => $user, 'userFollowing' => $unfollowUser));
    
                if(isset($following)) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($following);
                    $entityManager->flush();

                    return new Response();
                }
            }
        }
    }
}