<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\Game;
use AppBundle\Entity\Platform;
use AppBundle\Entity\Tournament;
use AppBundle\Entity\TournamentRule;
use AppBundle\Entity\TournamentPairing;
use AppBundle\Entity\User;
use AppBundle\Form\GameType;
use Doctrine\Common\Collections\ArrayCollection;



class TournamentsController extends Controller
{
    /**
     * @Route("/tournaments/{platform}", name="tournaments", options={"expose"=true})
     */
    public function indexAction(Request $request, $platform) {

        $repository_game = $this->getDoctrine()->getRepository(Game::class);
        $repository_platform = $this->getDoctrine()->getRepository(Platform::class);
        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);

        if($platform == "todos")
            $game_query = $repository_game->findAll();
        else {
            $platform_id = $repository_platform->findBy(array('name' => $platform));
            $game_query = $repository_game->findBy(array('platform' => $platform_id));
        }

        foreach($game_query as $game) {

            $platform_game = $repository_platform->find($game->getPlatform());

            $games[] = array(
                'id' => $game->getId(),
                'name_normalized' => str_replace("_"," ",$game->getName()),
                'name' => $game->getName(),
                'platform' => $platform_game->getName(),
                'image' => $game->getImage(),
                'num_active' => $repository_tournament->findCountActiveTournaments($game->getId(), $platform_game->getId())
            );
        }

        $platform_query = $repository_platform->findAll();

        foreach($platform_query as $p) {
            $platforms[] = array(
                'id' => $p->getId(),
                'name' => $p->getName()
            );
        }

        $game = new Game();
        $form = $this->createForm(GameType::class, $game);

        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($game);

        if($form->isSubmitted()) {
            
            if (count($errors) > 0) {
                return $this->render('@App/tournaments.html.twig', array(
                    'errors' => $errors, 'form' => $form->createView()
                ));
            } else {

                // upload file
                $file = $form["image"]->getData();
                $ext = $file->guessExtension();
                $file_name = time().".".$ext;
                $file->move("uploads/games",$file_name);

                $game->setImage($file_name);
                $game->setName(str_replace(" ", "_", $game->getName()));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($game);
                $entityManager->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Juego añadido correctamente');
                return $this->redirectToRoute('tournaments', array('platform' => $platform));
            }
        }

        return $this->render('@App/tournaments.html.twig', 
            array(
                "form" => $form->createView(),
                "games" => isset($games) ? $games : null,
                "platforms" => $platforms,
                "platform_selected" => $platform));
    }
    

    /**
     * @Route("/tournaments_game/{game_name}/{page}", name="game", options={"expose"=true}, defaults={"page":1}, requirements={"page":"\d+"})
     */
    public function gameAction(Request $request, $game_name, $page) {
        setlocale(LC_ALL, 'es_ES');
        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);
        $repository_game = $this->getDoctrine()->getRepository(Game::class);

        $game_query = $repository_game->findOneBy(array('name' => $game_name));

        if($game_query) {
            if($repository_tournament->findOneBy(array('game' => $game_query->getId()))) {
                $pageSize=10;
                $paginator=$repository_tournament->findByPaginateTournaments($pageSize,$page, $game_query->getId());
                $totalItems = count($paginator);
                $pagesCount = ceil($totalItems / $pageSize);
            }

            $game = array(
                'name_normalized' => str_replace("_", " ", $game_query->getName()),
                'name' => $game_query->getName(),
                'platform' => $game_query->getPlatform()->getName()
            );

            return $this->render('@App/game_tournament.html.twig', 
            array(
                'tournaments' => isset($paginator) ? $paginator : null, 
                'game' => isset($game) ? $game : null, 
                "pagesCount" => isset($pagesCount) ? $pagesCount : null, 
                'currentPage' => isset($page) ? $page : null,
                'historical' => false));
        }
        else {
            return $this->render('@App/error_page.html.twig');
        }  
    }

    /**
     * @Route("/tournaments_game_historical/{game_name}/{page}", name="game_historical", options={"expose"=true}, defaults={"page":1}, requirements={"page":"\d+"})
     */
    public function gameHistoricalAction(Request $request, $game_name, $page) {
        setlocale(LC_ALL, 'es_ES');
        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);
        $repository_game = $this->getDoctrine()->getRepository(Game::class);

        $game_query = $repository_game->findOneBy(array('name' => $game_name));

        if($game_query) {
            if($repository_tournament->findOneBy(array('game' => $game_query->getId()))) {
                $pageSize=10;
                $paginator=$repository_tournament->findByPaginateHistoricalTournaments($pageSize,$page, $game_query->getId());
                $totalItems = count($paginator);
                $pagesCount = ceil($totalItems / $pageSize);
            }

            $game = array(
                'name_normalized' => str_replace("_", " ", $game_query->getName()),
                'name' => $game_query->getName(),
                'platform' => $game_query->getPlatform()->getName()
            );

            return $this->render('@App/game_tournament.html.twig', 
                array(
                    'tournaments' => isset($paginator) ? $paginator : null, 
                    'game' => $game, 
                    "pagesCount" => isset($pagesCount) ? $pagesCount : null, 
                    'currentPage' => isset($page) ? $page : null,
                    'historical' => true));
        }
        else {
            return $this->render('@App/error_page.html.twig');
        }
    }


    /**
     * @Route("/new_tournament/{game_name}", name="new_tournament", options={"expose"=true})
     */
    public function newTournamentAction(Request $request, $game_name) {
        $repository_game = $this->getDoctrine()->getRepository(Game::class);

        $game_query = $repository_game->findOneBy(array('name' => $game_name));
        if($game_query) {
            $game = array(
                'name_normalized' => str_replace("_", " ", $game_query->getName()),
                'name' => $game_query->getName(),
                'platform' => $game_query->getPlatform()->getName()
            );
            
            return $this->render('@App/new_tournament.html.twig', array('game' => $game));
        }
        else {
            return $this->render('@App/error_page.html.twig');
        }
    }

    /**
     * @Route("/tournaments_new/create_tournament", name="create_tournament", options={"expose"=true})
     */
    public function createTournamentAction(Request $request) {
        setlocale(LC_ALL, 'es_ES');
        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);
        $repository_tournamentRule = $this->getDoctrine()->getRepository(TournamentRule::class);
        $repository_game = $this->getDoctrine()->getRepository(Game::class);

        $POST_DATA = $request->request->all();
        if($POST_DATA) {
            $game_name = $POST_DATA['data']['game_name'];
            $tournament_type = $POST_DATA['data']['tournament_type']; 
            $tournament_start = $POST_DATA['data']['tournament_date'];

            $numrules = $POST_DATA['data']['num_rules'];

            for($i = 0; $i < $numrules; $i++) {
                $rules[$i] = $request->get($i);
            }

            if($tournament_type === "liga") {
                $min_part = $POST_DATA['data']['min_part'];
                $max_part = $POST_DATA['data']['max_part'];
            }
            if($tournament_type === "eliminatoria") {
                $match_part = $POST_DATA['data']['match_part'];
            }

            $game = $repository_game->findOneBy(array('name' => $game_name));

            $tournament = new Tournament();
            $tournament->setType($tournament_type);
            $tournament->setDatetime(new \Datetime($tournament_start));
            $tournament->setGame($game);
            $tournament->setCurrentRound(1);
            
            $tournament->setParticipantsRequired((int)$match_part);

            $spanish_day = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
            $spanish_month = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

            $week_day = $spanish_day[$tournament->getDatetime()->format('w')];
            $month = $spanish_month[$tournament->getDatetime()->format('n') -1];
            $day = $tournament->getDatetime()->format('d');
            $tournament->setName("Torneo ".$week_day." ".$day." de ".$month);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tournament);
            $entityManager->flush();

            for($i = 0; $i < $numrules; $i++) {
                $rule = $POST_DATA['rules']['rule_'.$i];
                $tournamentRule = new TournamentRule();
                $tournamentRule->setRule($rule);
                $tournamentRule->setTournament($tournament);
                $entityManager->persist($tournamentRule);
                $entityManager->flush();
            }

            $this->get('session')->getFlashBag()->add('notice', 'Torneo creado correctamente');

            return new Response();
        }
        else {
            return $this->render('@App/error_page.html.twig');
        }
    }

    /**
     * @Route("/tournament_info/{game_name}/{id_tournament}", name="tournament_info", options={"expose"=true})
     */
    public function tournamentInfoAction(Request $request, $game_name, $id_tournament) {
        setlocale(LC_ALL, 'es_ES');
        date_default_timezone_set('Europe/Madrid');
        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);
        $repository_game = $this->getDoctrine()->getRepository(Game::class);
        $repository_tournamentRule = $this->getDoctrine()->getRepository(TournamentRule::class);

        $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();
        $registered = false;

        $game_query = $repository_game->findOneBy(array('name' => $game_name));

        if($game_query) {

            $tournament_query = $repository_tournament->findOneBy(array('id' => $id_tournament));
            if($tournament_query) {
                $tournamentRule_query = $repository_tournamentRule->findBy(array('tournament' => $tournament_query));
                
                $tournament_participants = $tournament_query->getParticipants()->toArray();

                foreach($tournament_participants as $user) {
                    $participants[] = array (
                        'username' => $user->getUsername()
                    );

                    if($user->getUsername() == $logged_user->getUsername())
                        $registered = true;
                }

                switch($game_query->getPlatform()->getName()) {
                    case 'PlayStation':
                        $platform_account_registered = $logged_user->getPlayStationId() != null ? true : false;
                        break;
                    case 'Xbox':
                        $platform_account_registered = $logged_user->getXboxId() != null ? true : false;
                        break;
                    case 'Steam':
                        $platform_account_registered = $logged_user->getSteamId() != null ? true : false;
                        break;
                }

                $string_limit_checkin = new \Datetime($tournament_query->getDatetime()->format('d-m-Y H:i'));
                $string_limit_checkin = date_sub($string_limit_checkin, date_interval_create_from_date_string('7 days'))->format('d M. H:i').'h';
                $object_limit_checkin = new \Datetime($tournament_query->getDatetime()->format('d-m-Y H:i'));
                $object_limit_checkin = date_sub($object_limit_checkin, date_interval_create_from_date_string('7 days'));

                $tournament_winner = $tournament_query->getWinner();
                if(isset($tournament_winner))
                    $tournament_winner = $tournament_query->getWinner()->getUsername();
                else {
                    $tournament_winner = null;
                }

                $num_part = isset($participants)? sizeof($participants) : 0;

                $tournament = array(
                    'id' => $tournament_query->getId(),
                    'name' => $tournament_query->getName(),
                    'game' => $tournament_query->getGame()->getName(),
                    'datetime' => $tournament_query->getDatetime()->format('d M. H:i').'h',
                    'datetime_object' => $tournament_query->getDatetime(),
                    'type' => $tournament_query->getType(),
                    'participants_required' => $tournament_query->getParticipantsRequired(),
                    'limit_checkin' => $string_limit_checkin,
                    'limit_checkin_object' => $object_limit_checkin,
                    'num_participants' => $num_part,
                    'winner' => $tournament_winner,
                    'is_active' => $tournament_query->getIsActive()
                );

                $game = array(
                    'name_normalized' => str_replace("_", " ", $game_query->getName()),
                    'name' => $game_query->getName(),
                    'platform' => $game_query->getPlatform()->getName()
                );

                foreach($tournamentRule_query as $rule) {
                    $rules[] = array(
                        'id' => $rule->getId(),
                        'rule' => $rule->getRule()
                    );
                }
                
                return $this->render('@App/tournament_info.html.twig', 
                    array(
                        'tournament' => $tournament, 
                        'game' => $game, 
                        'rules' => $rules, 
                        'participants' => isset($participants) ? $participants : null,
                        'registered' => $registered,
                        'registrable' => $platform_account_registered
                    ));
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
     * @Route("/pairing_generate", name="pairing_generate", options={"expose"=true}, condition="request.isXmlHttpRequest()")
     */
    public function pairingGenerateAction(Request $request) {

        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);
        $repository_pairing = $this->getDoctrine()->getRepository(TournamentPairing::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);

        $id_tournament = $request->request->get('tournament_id');

        $tournament_query = $repository_tournament->findOneBy(array('id' => $id_tournament));

        if($tournament_query->getCurrentRound() == 1)
            $participants_object = $tournament_query->getParticipants();
        else {
            $participants_object = new ArrayCollection();
            $pairings = $repository_pairing->findBy(
                array(
                    'tournament' => $tournament_query,
                    'round' => $tournament_query->getCurrentRound() - 1    
            ));
            
            foreach($pairings as $pair) {
                $participants_object->add($pair->getWinner());
            }
            
        }

        $i = 1;
        foreach($participants_object as $participant) {
            $participants[$i] = $participant->getUsername();
            $i++;
        }
        
        $tamanio = sizeof($participants);
        
        $index = 1;
        while(sizeof($participants) > 0) {
            if(sizeof($participants) >= 2){
                $elementos_aleatorios = array_rand($participants, 2);
                $combinacion["Partida ".$index]["Participante 1"] = $participants[$elementos_aleatorios[0]];
                $combinacion["Partida ".$index]["Participante 2"] = $participants[$elementos_aleatorios[1]];
                $playerOne = $repository_user->findOneBy(array('username' => $participants[$elementos_aleatorios[0]]));
                $playerTwo = $repository_user->findOneBy(array('username' => $participants[$elementos_aleatorios[1]]));
            }
            else {
                $elementos_aleatorios = array_rand($participants, 1);
                $combinacion["Partida ".$index]["Participante 1"] = $participants[$elementos_aleatorios];
                $combinacion["Partida ".$index]["Participante 2"] = $participants[$elementos_aleatorios];
                $playerOne = $repository_user->findOneBy(array('username' => $participants[$elementos_aleatorios]));
                $playerTwo = $playerOne;
            }

            $pair = new TournamentPairing();
            $pair->setPlayerOne($playerOne);
            $pair->setPlayerTwo($playerTwo);
            $pair->setRound($tournament_query->getCurrentRound());
            $pair->setTournament($tournament_query);
            if(sizeof($participants) == 1)
                $pair->setWinner($playerOne);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pair);
            $entityManager->flush();

            if(sizeof($participants) >= 2) {
                unset($participants[$elementos_aleatorios[0]]);
                unset($participants[$elementos_aleatorios[1]]); 
            }
            else
                unset($participants[$elementos_aleatorios]);
            $index++;
        }

        return $this->redirectToRoute('tournament_pairing', array(
            'game_name' => $tournament_query->getGame()->getName(),
            'id_tournament' => $id_tournament
        ));
    }

    /**
     * @Route("/tournament_pairing/{game_name}/{id_tournament}", name="tournament_pairing", options={"expose"=true})
     */
    public function tournamentPairingAction(Request $request, $game_name, $id_tournament) {
        setlocale(LC_ALL, 'es_ES');
        date_default_timezone_set('Europe/Madrid');
        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);
        $repository_game = $this->getDoctrine()->getRepository(Game::class);
        $repository_pairing = $this->getDoctrine()->getRepository(TournamentPairing::class);

        $game_query = $repository_game->findOneBy(array('name' => $game_name));

        if($game_query) {
            $tournament_query = $repository_tournament->findOneBy(array('id' => $id_tournament));
            if($tournament_query) {
                $current_round = $tournament_query->getCurrentRound();
                $num_rounds = round(log(sizeof($tournament_query->getParticipants()),2));

                for($i = 0; $i < $current_round; $i++) {
                    $tournament_pairings = $repository_pairing->findBy(
                        array(
                            'tournament'=>$tournament_query,
                            'round'=>$i+1));
                    foreach($tournament_pairings as $pair) {

                        $winner = $pair->getWinner();
                        if(isset($winner))
                            $winner = $pair->getWinner()->getUsername();
                        else {
                            $winner = null;
                        }
                        if($pair->getPlayerOne()->getUsername() != $pair->getPlayerTwo()->getUsername())
                            $pairings[] = array(
                                'id' => $pair->getId(),
                                'playerOne' => $pair->getPlayerOne()->getUsername(),
                                'playerTwo' => $pair->getPlayerTwo()->getUsername(),
                                'resultImgPOne' => $pair->getImageResultPlayerOne(),
                                'resultImgPTwo' => $pair->getImageResultPlayerTwo(),
                                'resultPOne' => $pair->getResultPlayerOne(),
                                'resultPTwo' => $pair->getResultPlayerTwo(),
                                'winner' => $winner,
                                'round' => $pair->getRound()
                            );
                        else {
                            $direct_pass = array(
                                $pair->getPlayerOne()->getUsername());
                        }
                    }
                    if(isset($pairings))
                        $pairings_total['Ronda'][$i+1] = $pairings;
                    unset($pairings);
                    if(isset($direct_pass)) {
                        $direct_pass_t['Ronda'][$i+1] = $direct_pass;
                        unset($direct_pass);
                    }
                }

                $string_limit_checkin = new \Datetime($tournament_query->getDatetime()->format('d-m-Y H:i'));
                $string_limit_checkin = date_sub($string_limit_checkin, date_interval_create_from_date_string('7 days'))->format('d M. H:i').'h';
                $object_limit_checkin = new \Datetime($tournament_query->getDatetime()->format('d-m-Y H:i'));
                $object_limit_checkin = date_sub($object_limit_checkin, date_interval_create_from_date_string('7 days'));

                $tournament_winner = $tournament_query->getWinner();
                if(isset($tournament_winner))
                    $tournament_winner = $tournament_query->getWinner()->getUsername();
                else {
                    $tournament_winner = null;
                }

                $num_part = isset($participants)? sizeof($participants) : 0;

                $tournament = array(
                    'id' => $tournament_query->getId(),
                    'name' => $tournament_query->getName(),
                    'game' => $tournament_query->getGame()->getName(),
                    'datetime' => $tournament_query->getDatetime()->format('d M. H:i').'h',
                    'datetime_object' => $tournament_query->getDatetime(),
                    'type' => $tournament_query->getType(),
                    'participants_required' => $tournament_query->getParticipantsRequired(),
                    'limit_checkin' => $string_limit_checkin,
                    'limit_checkin_object' => $object_limit_checkin,
                    'current_round' => $tournament_query->getCurrentRound(),
                    'num_rounds' => $num_rounds,
                    'winner' => $tournament_winner,
                    'is_active' => $tournament_query->getIsActive(),
                    'num_participants' => $num_part
                );

                $game = array(
                    'name_normalized' => str_replace("_", " ", $game_query->getName()),
                    'name' => $game_query->getName(),
                    'platform' => $game_query->getPlatform()->getName()
                );

                $pairings_current_round = $repository_pairing->findBy(array('tournament' => $tournament_query->getId(),'round' => $tournament_query->getCurrentRound()));

                if(!$pairings_current_round)
                    $pairings_generated = false;
                else
                    $pairings_generated = true;

                if(isset($pairings_total)) 
                    return $this->render('@App/tournament_pairing.html.twig', 
                        array(
                            'tournament' => $tournament, 
                            'game' => $game,
                            'pairings' => $pairings_total,
                            'num_rounds' => sizeof($pairings_total['Ronda']),
                            'last_round_generated' => $pairings_generated,
                            'direct_pass' => isset($direct_pass_t) ? $direct_pass_t : null
                        ));
                else 
                    return $this->render('@App/tournament_pairing.html.twig', 
                        array(
                            'tournament' => $tournament, 
                            'game' => $game,
                            'last_round_generated' => $pairings_generated
                        ));
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
     * @Route("/tournament_upload_result", name="tournament_upload_result", options={"expose"=true}, requirements={"methods":"POST"})
     */
    public function uploadResult(Request $request) {

        $repository_pairing = $this->getDoctrine()->getRepository(TournamentPairing::class);
        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);

        $entityManager = $this->getDoctrine()->getManager();
        
        $id_tournament = $request->request->get('tournament_id_player');
        $id_pairing = $request->request->get('pairing_id_player');
        $winner = $request->request->get('select_winner_player');

        if($id_tournament && $id_pairing && $winner) {
            $image_result = $request->files->get('input_result');
            $ext = $image_result->guessExtension();
            $file_name = time().".".$ext;
            $image_result->move("uploads/results",$file_name);

            $pairing = $repository_pairing->findOneBy(array('id' => $id_pairing));

            if($pairing->getPlayerOne()->getUsername() === $winner) {
                $pairing->setResultPlayerOne($winner);
                $pairing->setImageResultPlayerOne($file_name);
            }
            else {
                $pairing->setResultPlayerTwo($winner);
                $pairing->setImageResultPlayerTwo($file_name);
            }

            $entityManager->persist($pairing);
            $entityManager->flush();

            $tournament = $repository_tournament->find($id_tournament);

            return $this->redirectToRoute('tournament_pairing', 
                array(
                    'game_name' => $tournament->getGame()->getName(), 
                    'id_tournament' => $id_tournament));
        }
        else 
            return $this->render('@App/error_page.html.twig');
    }

    /**
     * @Route("download_image_pairing/{image_name}", name="download_img_pairing", options={"expose"=true})
     */
    public function downloadImageResult($image_name) {

        $images_path = $this->get('kernel')->getRootDir() . '/../web/uploads/results/';

        if(file_exists($images_path.$image_name)) {
            $file = new File($images_path.$image_name);
            return $this->file($file);
        }
        else   
            return $this->render('@App/error_page.html.twig');  
    }

    /**
     * @Route("/tournament_solve_pairing", name="tournament_solve_pairing", options={"expose"=true}, requirements={"methods":"POST"})
     */
    public function solvePairing(Request $request) {

        $repository_pairing = $this->getDoctrine()->getRepository(TournamentPairing::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);
        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);
        $entityManager = $this->getDoctrine()->getManager();
        
        $id_tournament = $request->request->get('tournament_id_mod');
        $id_pairing = $request->request->get('pairing_id_mod');
        $winner = $request->request->get('select_winner_mod');
        if($id_tournament && $id_pairing && $winner) {
            $pairing = $repository_pairing->findOneBy(array('id' => $id_pairing));
            $user = $repository_user->findOneBy(array('username' => $winner));
            $tournament = $repository_tournament->findOneBy(array('id' => $id_tournament));

            $pairing->setWinner($user);

            $entityManager->persist($pairing);
            $entityManager->flush();

            $round = $pairing->getRound();
            $num_rounds = round(log(sizeof($tournament->getParticipants()),2));

            $pairings_round = $repository_pairing->findBy(array('round' => $round));

            $complete_round = true;

            $idd = 0;

            foreach($pairings_round as $pair) {
                if($pair->getWinner() == null)
                    $complete_round = false;
            }

            if($complete_round == true) {
                if($num_rounds != $tournament->getCurrentRound()) {
                    $tournament->setCurrentRound($tournament->getCurrentRound()+1);
                    $entityManager->persist($tournament);
                    $entityManager->flush();
                }
                else {
                    $tournament->setWinner($user);
                    $tournament->setIsActive(false);
                    $entityManager->persist($tournament);
                    $entityManager->flush();
                }
            }

            return $this->redirectToRoute('tournament_pairing', array('game_name' => $tournament->getGame()->getName(), 'id_tournament' => $id_tournament));
        }
        else 
            return $this->render('@App/error_page.html.twig');
    }

    /**
     * @Route("/tournament_close/{id_tournament}", name="tournament_close", options={"expose"=true})
     */
    public function closeTournament($id_tournament) {
        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);
        $tournament = $repository_tournament->findOneBy(array('id' => $id_tournament));
        $entityManager = $this->getDoctrine()->getManager();
        if($tournament) {
            $tournament->setIsActive(false);
            $entityManager->persist($tournament);
            $entityManager->flush();

            return $this->redirectToRoute('game', array('game_name' => $tournament->getGame()->getName(), 'page' => 1));
        }
        else 
            return $this->render('@App/error_page.html.twig');
    }

    /**
     * @Route("/tournament_register", name="tournament_register", options={"expose"=true}, condition="request.isXmlHttpRequest()")
     */
    public function tournamentRegister(Request $request) {
        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);
        $entityManager = $this->getDoctrine()->getManager();

        $id_tournament = $request->request->get('tournament_id');
        $username = $request->request->get('username');

        $tournament = $repository_tournament->findOneBy(array('id' => $id_tournament));
        $user = $repository_user->findOneBy(array('username' => $username));

        if(sizeof($tournament->getParticipants()) != $tournament->getParticipantsRequired()) {
            $tournament->addParticipant($user);
            $entityManager->persist($tournament);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tournament_info', 
            array(
                'game_name' => $tournament->getGame()->getName(),
                'id_tournament' => $tournament->getId()
            ));
        
    }

}
