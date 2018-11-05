<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends Controller
{

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, 
        \Swift_Mailer $mailer)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if($form->isSubmitted()) {
            if (count($errors) > 0) {
                return $this->render('@App/register.html.twig', array(
                    'errors' => $errors, 'form' => $form->createView()
                ));
            } else {
                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                if($user->getProfileName() == null) $user->setProfileName($user->getUsername());

                // 4) save the User!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // ... do any other work - like sending them an email, etc
                // maybe set a "flash" success message for the user

                $message = (new \Swift_Message())
                ->setSubject('¡Bienvenido a Gaming Together!')
                ->setFrom(['soporte.gamingtogether@gmail.com' => 'Soporte de Gaming Together'])
                ->setTo($user->getEmail())
                ->setBody($this->renderView(
                    // AppBundle/Resources/views/Emails/registration_email.html.twig
                    '@App/Emails/registration_email.html.twig',
                    array('username' => $user->getUsername())
                ),
                'text/html');
                $mailer->send($message);

                $this->addFlash(
                    'dark',
                    'Se ha registrado correctamente. Revise su correo electrónico para activar su cuenta.'
                );

                return $this->redirectToRoute('index');
            }
        }

        return $this->render(
            '@App/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/active_account/{username}", name="active_account")
     */
    public function activeAccountAction($username) {
        
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneByUsername($username);

        $user->setIsActive(true);
        $entityManager->flush();

        $this->addFlash(
            'dark',
            'Su cuenta ha sido activada correctamente.'
        );

        return $this->redirectToRoute('index');
    }
}
