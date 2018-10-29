<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TournamentsController extends Controller
{
    /**
     * @Route("/tournaments", name="tournaments")
     */
    public function indexAction(Request $request) {
        return $this->render('@App/tournaments.html.twig');
    }

    /**
     * @Route("/tournaments/clash_royale", name="clash_royale")
     */
    public function clash_royaleAction(Request $request) {
        return $this->render('@App/clashroyale.html.twig');
    }
}
