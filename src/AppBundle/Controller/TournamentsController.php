<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Game;
use AppBundle\Entity\Platform;
use AppBundle\Entity\Tournament;
use AppBundle\Form\GameType;


class TournamentsController extends Controller
{
    /**
     * @Route("/tournaments/{platform}", name="tournaments", options={"expose"=true})
     */
    public function indexAction(Request $request, $platform) {

        $repository_game = $this->getDoctrine()->getRepository(Game::class);
        $repository_platform = $this->getDoctrine()->getRepository(Platform::class);

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
                'name' => $game->getName(),
                'platform' => $platform_game->getName(),
                'image' => $game->getImage()
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
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($game);
                $entityManager->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Juego añadido correctamente');
                return $this->redirectToRoute('tournaments');
            }
        }

        return $this->render('@App/tournaments.html.twig', 
            array(
                "form" => $form->createView(),
                "games" => $games,
                "platforms" => $platforms,
                "platform_selected" => $platform));
    }

    /**
     * @Route("/tournaments_game", name="game")
     */
    public function gameAction(Request $request) {
        return $this->render('@App/game_tournament.html.twig');
    }

    /**
     * @Route("/tournaments_json", name="tournaments_json", options={"expose"=true})
     */
    public function getJsonTournamentsAction() {
        $repository_tournament = $this->getDoctrine()->getRepository(Tournament::class);

        $tournament_query = $repository_tournament->findAll();
        
        foreach ($tournament_query as $tournament) {
            $tournaments["data"][] = array(
                'id' => $tournament->getId(),
                'game' => $tournament->getGame()->getName(),
                'datetime' => $tournament->getDatetime()->format('d-m-Y H:i'),
                'participants' => $tournament->getParticipants()
                );
        }
        if(isset($tournaments)) return new JsonResponse($tournaments);
        else return new JsonResponse();
    }
}
