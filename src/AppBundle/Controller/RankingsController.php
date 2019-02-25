<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\GameGroup;
use AppBundle\Entity\GameGroupVote;
use AppBundle\Entity\Post;
use AppBundle\Entity\PostLike;
use AppBundle\Entity\Tournament;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class RankingsController extends Controller
{
    /**
     * @Route("/rankings", name="rankings")
     */
    public function indexAction(Request $request) {
        
        return $this->render('@App/rankings.html.twig');
    }

    /**
     * @Route("/filter_ranking", name="filter_ranking",options={"expose"=true}, condition="request.isXmlHttpRequest()")
     */
    public function filterRankingAction(Request $request) {
        $repository_gamegroup = $this->getDoctrine()->getRepository(GameGroup::class);
        $repository_gamegroup_vote = $this->getDoctrine()->getRepository(GameGroupVote::class);
        $repository_tournaments = $this->getDoctrine()->getRepository(Tournament::class);
        $repository_post = $this->getDoctrine()->getRepository(Post::class);
        $repository_postslikes = $this->getDoctrine()->getRepository(PostLike::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);

        $filter_parameter = $request->request->get('filter_parameter');
        $date_begin = $request->request->get('date_begin');
        $date_end = $request->request->get('date_end');
        
        switch($filter_parameter) {
            case "best_posts":
                $best_posts = $repository_postslikes->getBestPosts(new \Datetime($date_begin." 00:00:00"), new \Datetime($date_end." 23:59:59"));
                foreach($best_posts as $post_element) {
                    $post = $repository_post->find($post_element['id_post']);
                    $posts[] = array(
                        'id' => $post->getId(),
                        'text' => $post->getText(),
                        'datetime' => $post->getDatetime(),
                        'image' => $post->getImage(),
                        'user' => $post->getUser(),
                        'num_likes' => $post_element['total']
                    );
                }
                if(isset($posts)) {
                    return $this->render('@App/ranking_posts.html.twig', array('posts' => $posts));
                }
                else
                    return new Response("<p style='text-align: center; vertical-align: middle;'>No se han encontrado publicaciones en el intervalo introducido</p>");
                break;
            case "voted_users":
                $best_group_users = $repository_gamegroup_vote->getBestVotedUsers(new \Datetime($date_begin." 00:00:00"), new \Datetime($date_end." 23:59:59"));
                foreach($best_group_users as $user_element) {
                    $user = $repository_user->find($user_element['id_user']);
                    $votedUsers[] = array(
                        'id' => $user->getId(),
                        'username' => $user->getUsername(),
                        'profileName' => $user->getProfileName(),
                        'puntuation' => round($user_element['total'],2),
                        'steam_id' => $user->getSteamId(),
                        'xbox_id' => $user->getXboxId(),
                        'psn_id' => $user->getPsnId()
                    );
                }
                if(isset($votedUsers)) {
                    return $this->render('@App/ranking_voted_users.html.twig', array('voted_users' => $votedUsers));
                }
                else
                    return new Response("<p style='text-align: center; vertical-align: middle;'>No se han encontrado usuarios votados en el intervalo introducido</p>");
                break;
            case "winners":
                $best_winners = $repository_tournaments->getMostTournamentsWinners(new \Datetime($date_begin." 00:00:00"), new \Datetime($date_end." 23:59:59"));
                foreach($best_winners as $winner_element) {
                    $user = $repository_user->find($winner_element['id_user']);
                    $winners[] = array(
                        'id' => $user->getId(),
                        'username' => $user->getUsername(),
                        'profileName' => $user->getProfileName(),
                        'num_wins' => $winner_element['total'],
                        'steam_id' => $user->getSteamId(),
                        'xbox_id' => $user->getXboxId(),
                        'psn_id' => $user->getPsnId()
                    );
                }
                if(isset($winners)) {
                    return $this->render('@App/ranking_winners.html.twig', array('winners' => $winners));
                }
                else
                    return new Response("<p style='text-align: center; vertical-align: middle;'>No se han encontrado ganadores de torneos en el intervalo introducido</p>");
                break;
        }
    }

}