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
     * @Route("/follow/{id_user}/{id_follower}", name="follow_user", options={"expose"=true},condition="request.isXmlHttpRequest()")
     * Función para seguir a un usuario
     */
    public function followAction($id_user, $id_follower) {
 
        $repository_following = $this->getDoctrine()->getRepository(Following::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);

        if($id_user != $id_follower) { // No podemos seguirnos a nosotros mismos
            $user = $repository_user->findOneBy(array('id' => $id_user));
            $followUser = $repository_user->findOneBy(array('id' => $id_follower));

            if(isset($user) && isset($followUser)) { // Si encontramos ambos usuarios
                $following = $repository_following->findOneBy(array(
                    'user' => $user, 'userFollowing' => $followUser));
    
                if(!isset($following)) { // En caso de no seguirlo ya se crea el registro en la BD
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
     * @Route("/unfollow/{id_user}/{id_follower}", name="unfollow_user", options={"expose"=true},condition="request.isXmlHttpRequest()")
     * Función para dejar de seguir a un usuario
     */
    public function unfollowAction($id_user, $id_follower) {
 
        $repository_following = $this->getDoctrine()->getRepository(Following::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);

        if($id_user != $id_follower) { // No podemos seguirnos a nosotros mismos
            $user = $repository_user->findOneBy(array('id' => $id_user));
            $unfollowUser = $repository_user->findOneBy(array('id' => $id_follower));

            if(isset($user) && isset($unfollowUser)) { // Si se encuentran ambos usuarios se procede
                $following = $repository_following->findOneBy(array(
                    'user' => $user, 'userFollowing' => $unfollowUser));
    
                if(isset($following)) { // Si lo está siguiendo se deja de seguir
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($following);
                    $entityManager->flush();

                    return new Response();
                }
            }
        }
    }
}