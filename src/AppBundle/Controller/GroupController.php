<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\GameGroupType;
use AppBundle\Entity\GameGroup;

class GroupController extends Controller
{
    /**
     * @Route("/group", name="group")
     */
    public function indexAction(Request $request)
    {
                // 1) build the form
                $group = new GameGroup();
                $form = $this->createForm(GameGroupType::class, $group);
        
                // 2) handle the submit (will only happen on POST)
                $form->handleRequest($request);
        
                $validator = $this->get('validator');
                $errors = $validator->validate($group);
        
                if($form->isSubmitted()) {
                    if (count($errors) > 0) {
                        
                    } else {
                        return $this->redirectToRoute('index');
                    }
                }
        
                return $this->render(
                    '@App/groups.html.twig',
                    array('form' => $form->createView())
                );
    }
}
