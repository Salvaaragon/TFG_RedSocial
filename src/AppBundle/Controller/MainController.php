<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@App/homepage.html.twig');
    }
}