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

        $group_query = $repository_gamegroup->findBy(
            array('isActive' => 1),
            array('datetime' => 'ASC'));
        $platform_query = $repository_platform->findAll();

        $num_groups = $repository_gamegroup->getNumGroupsUser(
            $this->container->get('security.token_storage')->getToken()->getUser()
        );
        
        foreach($group_query as $group) {

            $participants = $this->format_group_participants($group);

            $groups[] = array(
                'id' => $group->getId(),
                'game' => $group->getGame(),
                'platform' => $group->getPlatform()->getName(),
                'user' => $group->getUser()->getUsername(),
                'max_participants' => $group->getMaxParticipants(),
                'datetime' => $group->getDatetime()->format('d-m-Y H:i'),
                'participants' => $participants,
                'isActive' => $group->getIsActive(),
                'num_part' => $group->getParticipants()->count()
            );
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
            /*// 1) build the form
                $group = new GameGroup();
                $form = $this->createForm(GameGroupType::class, $group);
        
                // 2) handle the submit (will only happen on POST)
                $form->handleRequest($request);
        
                $validator = $this->get('validator');
                $errors = $validator->validate($group);
        
                if($form->isSubmitted()) {
                    if (count($errors) > 0) {
                        return $this->render('@App/group.html.twig', array(
                            'errors' => $errors, 'form' => $form->createView()
                        ));
                    } else {
                        $user = $this->getUser();
                        $group->setUser($user);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($group);
                        $entityManager->flush();
                        return $this->redirectToRoute('index');
                    }
                }
        
                return $this->render(
                    '@App/groups.html.twig',
                    array('form' => $form->createView())
                );*/
    }

    /**
     * @Route("/group/get_groups/{filter_group}/{id_platform}", name="groups_json", options={"expose"=true})
     */
    public function get_groups($filter_group, $id_platform) {
        $repository_gamegroup = $this->getDoctrine()->getRepository(GameGroup::class);

        switch($filter_group) {
            case "all": 
                if($id_platform != 0) 
                    $group_query = $repository_gamegroup->findBy(
                        array('platform' => $id_platform, 'isActive' => 1), array('datetime' => 'ASC'));
                else
                    $group_query = $repository_gamegroup->findBy(
                        array('isActive' => 1), array('datetime' => 'ASC'));
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
        }
        
        foreach($group_query as $group) {
            $participants = $this->format_group_participants($group);

            $groups[] = array(
                'id' => $group->getId(),
                'game' => $group->getGame(),
                'platform' => $group->getPlatform()->getName(),
                'user' => $group->getUser()->getUsername(),
                'max_participants' => $group->getMaxParticipants(),
                'datetime' => $group->getDatetime()->format('d-m-Y H:i'),
                'participants' => $participants,
                'isActive' => $group->getIsActive(),
                'num_part' => $group->getParticipants()->count()
            );
        }

        if(isset($groups))
            return $this->render('@App/group_list.html.twig', array(
                "groups" => $groups));  
        else
                return $this->render('@App/group_list.html.twig');
    }

    /**
     * @Route("/group/close_group/{id_group}", name="close_group", options={"expose"=true})
     */
    public function close_group($id_group) {
        $entityManager = $this->getDoctrine()->getManager();

        $group = $entityManager->getRepository(GameGroup::class)->find($id_group);

        $group->setIsActive(false);
        $entityManager->flush();
        $this->get('session')->getFlashBag()->add('notice', 'Grupo cerrado correctamente');

        return $this->redirectToRoute('group');
    }
    
    /**
     * @Route("/group/register_group/{id_group}/{id_user}", name="register_group", options={"expose"=true})
     */
    public function register_group($id_group, $id_user) {
        $entityManager = $this->getDoctrine()->getManager();

        $group = $entityManager->getRepository(GameGroup::class)->find($id_group);
        $user = $entityManager->getRepository(User::class)->find($id_user);

        $group->addParticipant($user);
        $entityManager->flush();
        $this->get('session')->getFlashBag()->add('notice', 'Se ha registrado en el grupo de forma correcta');

        return $this->redirectToRoute('group');
    }

    /**
     * @Route("/group/signdown_group/{id_group}", name="signdown_group", options={"expose"=true})
     */
    public function signdown_group($id_group) {
        $entityManager = $this->getDoctrine()->getManager();

        $group = $entityManager->getRepository(GameGroup::class)->find($id_group);

        $user = $this->getUser();

        $group->getParticipants()->removeElement($user);

        $entityManager->flush();
        $this->get('session')->getFlashBag()->add('notice', 'Ha abandonado el grupo correctamente');

        return $this->redirectToRoute('group');
    }

    public function format_group_participants($group) {
        $participants = $group->getParticipants()->toArray();
        
        $format_participants = "";

        foreach($participants as $user) {
            $format_participants = $format_participants . $user->getUsername() . ",";
        }

        return substr($format_participants, 0, strlen($format_participants) -1);
    }

    /**
     * @Route("/group/chat/{id_group}", name="chat", options={"expose"=true})
     */
    public function chat_group($id_group) {
        $entityManager = $this->getDoctrine()->getManager();

        $group = $entityManager->getRepository(GameGroup::class)->find($id_group);

        $game_group = array(
            'id' => $group->getId(),
            'game' => $group->getGame(),
            'platform' => $group->getPlatform(),
            'user' => $group->getUser()->getUsername(),
            'max_participants' => $group->getMaxParticipants(),
            'datetime' => $group->getDatetime()->format('d-m-Y H:i')
        );

        return $this->render('@App/chat_prueba.html.twig', array("group" => $game_group));
    }

    /**
     * @Route("/group/chat/{id_group}/get_messages", name="get_messages", options={"expose"=true})
     */
    public function get_messages($id_group) {
        $entityManager = $this->getDoctrine()->getManager();

        $group = $entityManager->getRepository(GameGroup::class)->find($id_group);

        $message_query = $entityManager->getRepository(Message::class)->getLastMessagesGroup($group);

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

    /**
     * @Route("/group/chat/{id_group}/add_message", name="add_message", options={"expose"=true})
     */
    public function add_message(Request $request) {
        date_default_timezone_set('Europe/Madrid');
        
        $entityManager = $this->getDoctrine()->getManager();

        $id_group = $request->request->get('id_group');
        $id_user = $request->request->get('id_user');
        $message = $request->request->get('message');

        $group = $entityManager->getRepository(GameGroup::class)->find($id_group);
        $user = $entityManager->getRepository(User::class)->find($id_user);

        $chat_message = new Message();

        $chat_message->setGameGroup($group);
        $chat_message->setUser($user);
        $chat_message->setDatetime(new \Datetime('now'));
        $chat_message->setMessage($message);

        $entityManager->persist($chat_message);
        $entityManager->flush();

        return new Response();
    }
    
}
