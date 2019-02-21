<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\GameGroupType;
use AppBundle\Entity\GameGroup;
use AppBundle\Entity\Platform;
use AppBundle\Entity\User;
use AppBundle\Entity\Message;
use AppBundle\Entity\GameGroupVote;
use Symfony\Component\HttpFoundation\JsonResponse;

class GroupController extends Controller
{
    /**
     * @Route("/group", name="group")
     */
    public function indexAction(Request $request)
    {
        date_default_timezone_set('Europe/Madrid');
        $repository_gamegroup = $this->getDoctrine()->getRepository(GameGroup::class);
        $repository_platform = $this->getDoctrine()->getRepository(Platform::class);
        $repository_gamegroup_vote = $this->getDoctrine()->getRepository(GameGroupVote::class);

        $group_query = $repository_gamegroup->findBy(
            array('isActive' => 1),
            array('datetime' => 'ASC'));
        $platform_query = $repository_platform->findAll();

        $num_groups = $repository_gamegroup->getNumGroupsUser(
            $this->container->get('security.token_storage')->getToken()->getUser()
        );
        
        $now_date = new \Datetime('now');
        $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();
        
        foreach($group_query as $group) {

            $participants = $this->format_group_participants($group);
            $group_user_is_participant = false;
            $user_participant_has_vote = false;

            if($logged_user->getUsername() == $group->getUser()->getUsername())
                $group_user_is_participant = true;
            if($this->user_is_participant($group->getParticipants(), $logged_user->getUsername()))
                $group_user_is_participant = true;

            if($group_user_is_participant) {
                $vote = $repository_gamegroup_vote->findOneBy(
                    array(
                        'user' => $logged_user->getId(),
                        'gameGroup' => $group->getId()));
                if($vote)
                    $user_participant_has_vote = true;
            }

            if($now_date < $group->getDatetime()) {

                $groups[] = array(
                    'id' => $group->getId(),
                    'game' => $group->getGame(),
                    'platform' => $group->getPlatform()->getName(),
                    'user' => $group->getUser()->getUsername(),
                    'max_participants' => $group->getMaxParticipants(),
                    'datetime' => $group->getDatetime()->format('d-m-Y H:i'),
                    'participants' => $participants,
                    'isActive' => $group->getIsActive(),
                    'num_part' => $group->getParticipants()->count(),
                    'user_is_participant' => $group_user_is_participant,
                    'user_has_vote' => $user_participant_has_vote
                );
            }
        }

        $group = new GameGroup();
        $form = $this->createForm(GameGroupType::class, $group, array('user' => $this->getUser()));

        $form->handleRequest($request);
        
            $validator = $this->get('validator');
            $errors = $validator->validate($group);
    
            if($form->isSubmitted()) {
                $form_datetime = strtotime(($form->get('datetime')->getData())->format('d-m-Y H:i'));
                $min_datetime = strtotime(date("d-m-Y H:i", strtotime('+ 1 hour')));
                
                if (count($errors) > 0) {
                    return $this->render('@App/groups.html.twig', array(
                        'errors' => $errors, 'form' => $form->createView()
                    ));
                } else {
                    if($form_datetime < $min_datetime) {
                        $this->get('session')->getFlashBag()->add('error', 'Fecha introducida no válida');
                        return $this->redirectToRoute('group');
                    }
                    else {
                        $user = $this->getUser();
                        $group->setUser($user);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($group);
                        $entityManager->flush();
                        $this->get('session')->getFlashBag()->add('notice', 'Grupo creado correctamente');
                        return $this->redirectToRoute('group');
                    }
                }
            }
            if(isset($groups))
                return $this->render('@App/groups.html.twig', array(
                    "groups" => $groups,
                    "num_groups_user" => $num_groups,
                    "platforms" => $platform_query,
                    "form" => $form->createView()));
            else 
                return $this->render('@App/groups.html.twig', array(
                    "platforms" => $platform_query,
                    "form" => $form->createView()));
    }

    /**
     * @Route("/group/get_groups/{filter_group}/{id_platform}", name="groups_json", options={"expose"=true})
     */
    public function get_groups($filter_group, $id_platform) {
        $repository_gamegroup = $this->getDoctrine()->getRepository(GameGroup::class);
        $repository_gamegroup_vote = $this->getDoctrine()->getRepository(GameGroupVote::class);

        switch($filter_group) {
            case "all": 
                if($id_platform != 0) 
                    $group_query = $repository_gamegroup->getAllGroupsActivePlatformNotPlaying($id_platform);
                else
                    $group_query = $repository_gamegroup->getAllGroupsActiveNotPlaying();
                break;        
            case "mygroups":
                if($id_platform != 0) 
                    $group_query = $repository_gamegroup->findBy(
                        array('platform' => $id_platform, 'isActive' => 1, 'user' => $this->getUser()),
                        array('datetime' => 'ASC'));
                else
                    $group_query = $repository_gamegroup->findBy(
                        array('isActive' => 1, 'user' => $this->getUser()), array('datetime' => 'ASC'));
                break;    
            case "myregister":
                if($id_platform != 0) 
                    $group_query = $repository_gamegroup->getGroupsPlatformUserpart($id_platform, $this->getUser()->getId());
                else
                   $group_query = $repository_gamegroup->getGroupsUserpart($this->getUser()->getId());
                break;    
            case "history_mygroups":
                if($id_platform != 0) 
                    $group_query = $repository_gamegroup->getAllGroupsPlatformUser($id_platform, $this->getUser()->getId());
                else
                    $group_query = $repository_gamegroup->getAllGroupsUser($this->getUser()->getId());
                break;
            case "history_myregister":
                if($id_platform != 0) 
                    $group_query = $repository_gamegroup->getAllPartPlatformUser($id_platform, $this->getUser()->getId());
                else
                    $group_query = $repository_gamegroup->getAllPartUser($this->getUser()->getId());
                break;
            case "groups_playing":
                if($id_platform != 0)
                    $group_query = $repository_gamegroup->getAllGroupsPlayingPlatform($id_platform);
                else
                    $group_query = $repository_gamegroup->getAllGroupsPlaying();
                break;
        }

        if(isset($group_query)) {

            $now_date = new \Datetime('now');
            $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();
            
            foreach($group_query as $group) {
                $participants = $this->format_group_participants($group);

                $group_user_is_participant = false;
                $user_participant_has_vote = false;

                if($logged_user->getUsername() == $group->getUser()->getUsername())
                    $group_user_is_participant = true;
                if($this->user_is_participant($group->getParticipants(), $logged_user->getUsername()))
                    $group_user_is_participant = true;

                if($group_user_is_participant) {
                    $vote = $repository_gamegroup_vote->findOneBy(
                        array(
                            'user' => $logged_user->getId(),
                            'gameGroup' => $group->getId()));
                    if($vote)
                        $user_participant_has_vote = true;
                }

                if($filter_group == 'all') {
                    if($now_date < $group->getDatetime()) {
                        $groups[] = array(
                            'id' => $group->getId(),
                            'game' => $group->getGame(),
                            'platform' => $group->getPlatform()->getName(),
                            'user' => $group->getUser()->getUsername(),
                            'max_participants' => $group->getMaxParticipants(),
                            'datetime' => $group->getDatetime()->format('d-m-Y H:i'),
                            'participants' => $participants,
                            'isActive' => $group->getIsActive(),
                            'num_part' => $group->getParticipants()->count(),
                            'user_is_participant' => $group_user_is_participant,
                            'user_has_vote' => $user_participant_has_vote
                        );
                    }
                }
                else {
                    $groups[] = array(
                        'id' => $group->getId(),
                        'game' => $group->getGame(),
                        'platform' => $group->getPlatform()->getName(),
                        'user' => $group->getUser()->getUsername(),
                        'max_participants' => $group->getMaxParticipants(),
                        'datetime' => $group->getDatetime()->format('d-m-Y H:i'),
                        'participants' => $participants,
                        'isActive' => $group->getIsActive(),
                        'num_part' => $group->getParticipants()->count(),
                        'user_is_participant' => $group_user_is_participant,
                        'user_has_vote' => $user_participant_has_vote
                    );
                }
            }

            if(isset($groups))
                return $this->render('@App/group_list.html.twig', array(
                    "groups" => $groups));  
            else
                    return $this->render('@App/group_list.html.twig');
        }
        else
            return $this->render('@App/error_page.html.twig');
    }

    private function user_is_participant($participants, $username) {
        $participants_array = $participants->toArray();
        $is_participant = false;
        foreach($participants_array as $participant) {
            if($participant->getUsername() == $username)
                $is_participant = true;
        }

        return $is_participant;
    }

    /**
     * @Route("/group/close_group/{id_group}", name="close_group", options={"expose"=true})
     */
    public function close_group($id_group) {
        $entityManager = $this->getDoctrine()->getManager();

        $group = $entityManager->getRepository(GameGroup::class)->find($id_group);

        if($group && $group->getUser()->getUsername() == $this->getUser()->getUsername()) {

            if($group->getIsActive()) {
                $group->setIsActive(false);
                $entityManager->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Grupo cerrado correctamente');
            }
            return $this->redirectToRoute('group');
        }
        else
            return $this->render('@App/error_page.html.twig');
    }
    
    /**
     * @Route("/group/register_group/{id_group}/{id_user}", name="register_group", options={"expose"=true})
     */
    public function register_group($id_group, $id_user) {
        $entityManager = $this->getDoctrine()->getManager();

        $group = $entityManager->getRepository(GameGroup::class)->find($id_group);
        $user = $entityManager->getRepository(User::class)->find($id_user);
        if($group && $user && $group->getUser()->getUsername() != $user->getUsername()) {
            $group->addParticipant($user);
            $entityManager->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Se ha registrado en el grupo de forma correcta');
        }
        return $this->redirectToRoute('group');
    }

    /**
     * @Route("/group/signdown_group/{id_group}", name="signdown_group", options={"expose"=true})
     */
    public function signdown_group($id_group) {
        $entityManager = $this->getDoctrine()->getManager();

        $group = $entityManager->getRepository(GameGroup::class)->find($id_group);

        if($group) {
            $user = $this->getUser();

            $group->getParticipants()->removeElement($user);

            $entityManager->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Ha abandonado el grupo correctamente');
        }
        return $this->redirectToRoute('group');
    }

    private function format_group_participants($group) {
        $participants = $group->getParticipants()->toArray();
        
        $format_participants = "";

        foreach($participants as $user) {
            $format_participants = $format_participants . $user->getUsername() . ",";
        }

        return substr($format_participants, 0, strlen($format_participants) -1);
    }

    /**
     * @Route("/group/chat/{id_group}/get_messages", name="get_messages", options={"expose"=true})
     */
    public function get_messages($id_group) {
        $entityManager = $this->getDoctrine()->getManager();

        $group = $entityManager->getRepository(GameGroup::class)->find($id_group);

        $message_query = $entityManager->getRepository(Message::class)->getLastMessagesGroup($group);
        
        if($group) {
            if($group->getUser()->getUsername() == $this->getUser()->getUsername()
            || $this->user_is_participant($group->getParticipants(),$this->getUser()->getUsername())) {
            foreach($message_query as $msg) {
                $messages[] = array(
                    'datetime' => $msg->getDatetime()->format('d-m-Y H:i'),
                    'username' => $msg->getUser()->getUsername(),
                    'message' => $msg->getMessage()
                );
            }
            if(isset($messages))
                return $this->render('@App/chat_content.html.twig', array(
                    "messages" => $messages));  
            else
                return new Response("No existen mensajes en este grupo");
            }
            else
                return new Response("No tiene acceso a este chat");
        }
        else 
            return $this->render('@App/error_page.html.twig');

    }

    /**
     * @Route("/group/chat/{id_group}/add_message", name="add_message", options={"expose"=true})
     */
    public function add_message(Request $request) {
        date_default_timezone_set('Europe/Madrid');
        
        $entityManager = $this->getDoctrine()->getManager();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_group = $request->request->get('id_group');
            $id_user = $request->request->get('id_user');
            $message = $request->request->get('message');

            $group = $entityManager->getRepository(GameGroup::class)->find($id_group);
            $user = $entityManager->getRepository(User::class)->find($id_user);

            if($group && $user) {
                if($group->getUser()->getUsername() == $user->getUsername()
                || $this->user_is_participant($group->getParticipants(),$user->getUsername())) {
                    $chat_message = new Message();

                    $chat_message->setGameGroup($group);
                    $chat_message->setUser($user);
                    $chat_message->setDatetime(new \Datetime('now'));
                    $chat_message->setMessage($message);

                    $entityManager->persist($chat_message);
                    $entityManager->flush();

                    return new Response();
                }
                else 
                    return $this->render('@App/error_page.html.twig');
            }
        }
    }

    /**
     * @Route("/group/vote/{id_group}", name="group_vote", options={"expose"=true}) 
     */
    public function groupVoteAction($id_group) {

        $repository_gamegroup = $this->getDoctrine()->getRepository(GameGroup::class);

        $group = $repository_gamegroup->find($id_group);

        if($group) {
            $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();

            if($logged_user->getUsername() == $group->getUser()->getUsername() || 
                $this->user_is_participant($group->getParticipants(), $logged_user->getUsername())) {
                
                $participants = $group->getParticipants()->toArray();

                $group_array = array(
                    'id' => $group->getId(),
                    'game' => $group->getGame(),
                    'datetime' => $group->getDatetime()->format('d-m-Y H:i'),
                    'user' => $group->getUser()->getUsername() 
                );

                if($logged_user->getUsername() == $group->getUser()->getUsername())
                    foreach($participants as $part) {
                        $participants_array[] = array('username' => $part->getUsername());
                    }
                else {
                    $participants_array[] = array('username' => $group->getUser()->getUsername());
                    foreach($participants as $part) {
                        if($part->getUsername() != $logged_user->getUsername())
                            $participants_array[] = array('username' => $part->getUsername());
                    }
                }
                return $this->render('@App/group_vote.html.twig', 
                    array('participants' => $participants_array, 'group' => $group_array));
            }

            else {
                return $this->render('@App/error_page.html.twig');
            }
        }
        else {
            return $this->render('@App/error_page.html.twig');
        } 
    }

    /**
     * @Route("/save_vote", name="save_vote", options={"expose"=true}, requirements={"methods":"POST"})
     */
    public function saveVoteAction(Request $request) {
        date_default_timezone_set('Europe/Madrid');
        $repository_gamegroup = $this->getDoctrine()->getRepository(GameGroup::class);
        $repository_gamegroup_vote = $this->getDoctrine()->getRepository(GameGroupVote::class);

        $entityManager = $this->getDoctrine()->getManager();

        $id_group = $request->request->get('game_group_id');

        $group = $repository_gamegroup->find($id_group);

        $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();

        if($_SERVER['REQUEST_METHOD'] === 'POST' && $group) {
            if($logged_user->getUsername() == $group->getUser()->getUsername()) {
                $participants = $group->getParticipants()->toArray();
                foreach($participants as $part) {
                    $vote[] = array(
                        'user' => $part, 
                        'vote' => $request->request->get('select_'.$part->getUsername()));
                }
            }
            else {
                $vote[] = array(
                        'user' => $group->getUser(), 
                        'vote' => $request->request->get('select_'.$group->getUser()->getUsername()));
                        $participants = $group->getParticipants()->toArray();
                foreach($participants as $part) {
                    if($part->getUsername() != $logged_user->getUsername())
                        $vote[] = array(
                            'user' => $part, 
                            'vote' => $request->request->get('select_'.$part->getUsername()));
                }
            }

            $now_date = new \Datetime('now');
            foreach($vote as $vote_data) {
                $vote_object = new GameGroupVote();
                $vote_object->setUser($logged_user);
                $vote_object->setUserVoted($vote_data['user']);
                $vote_object->setGameGroup($group);
                $vote_object->setVote($vote_data['vote']);
                $vote_object->setDatetime(new \Datetime('now'));

                $entityManager->persist($vote_object);
                $entityManager->flush();
            }  

            if($this->allParticipantsHasVote($group)) {
                $group->setIsActive(false);
                $entityManager->persist($group);
                $entityManager->flush();
            }

            $this->get('session')->getFlashBag()->add('notice', 'Ha votado de manera satisfactoria');
            return $this->redirectToRoute('group');
        }
        else 
            return $this->render('@App/error_page.html.twig');
    }

    private function allParticipantsHasVote(GameGroup $group) {
        $repository_gamegroup = $this->getDoctrine()->getRepository(GameGroup::class);
        $repository_gamegroup_vote = $this->getDoctrine()->getRepository(GameGroupVote::class);

        $all_participants_has_vote = true;

        $leader_vote = $repository_gamegroup_vote->findOneBy(
            array(
                'user' => $group->getUser()->getId(),
                'gameGroup' => $group));

        if(!$leader_vote) $all_participants_has_vote = false;

        $participants = $group->getParticipants()->toArray();

        foreach($participants as $part) {
            $participant_vote = $repository_gamegroup_vote->findOneBy(
                array(
                    'user' => $part->getId(),
                    'gameGroup' => $group
                ));
            if(!$participant_vote) $all_participants_has_vote = false;
        }

        return $all_participants_has_vote;
    }
    
}
