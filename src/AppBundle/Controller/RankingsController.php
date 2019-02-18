<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class RankingsController extends Controller
{
    /**
     * @Route("/rankings", name="rankings")
     */
    public function indexAction(Request $request) {

    }

}