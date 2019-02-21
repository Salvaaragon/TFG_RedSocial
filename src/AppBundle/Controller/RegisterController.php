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
     * Función que genera el formulario de registro y lo muestra en la vista
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, 
        \Swift_Mailer $mailer)
    {
        if($this->container->get('security.token_storage')->getToken()->getUser() != "anon.")
            return $this->redirectToRoute('homepage');
        else {
            // Generamos el formulario
            $user = new User();
            $form = $this->createForm(UserType::class, $user);

            // handle the submit (will only happen on POST)
            $form->handleRequest($request);

            $validator = $this->get('validator');
            $errors = $validator->validate($user);

            if($form->isSubmitted()) {
                if (count($errors) > 0) {
                    return $this->render('@App/index/register.html.twig', array(
                        'errors' => $errors, 'form' => $form->createView()
                    ));
                } else {
                    // Encriptamos la contraseña
                    $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                    $user->setPassword($password);

                    if($user->getProfileName() == null) $user->setProfileName($user->getUsername());

                    // Se almacena el usuario en la base de datos
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($user);
                    $entityManager->flush();

                    // Y se envía un mensaje de correo electrónico solicitándole al mismo que active su cuenta
                    // y dándole la bienvenida
                    $message = (new \Swift_Message())
                    ->setSubject('¡Bienvenido a Gaming Together!')
                    ->setFrom(['soporte.gamingtogether@gmail.com' => 'Soporte de Gaming Together'])
                    ->setTo($user->getEmail())
                    ->setBody($this->renderView(
                        '@App/emails/registration_email.html.twig',
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
                '@App/index/register.html.twig',
                array('form' => $form->createView())
            );
        }
    }

    /**
     * Función que permite activar la cuenta de usuario
     * @Route("/active_account/{username}", name="active_account")
     */
    public function activeAccountAction($username) {
        
        if($this->container->get('security.token_storage')->getToken()->getUser() != "anon.")
            return $this->redirectToRoute('homepage');
        else {
            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneByUsername($username);

            if($user) {
                if(!$user->isEnabled()) {
                    $user->setIsActive(true);
                    $entityManager->flush();

                    $this->addFlash(
                        'dark',
                        'Su cuenta ha sido activada correctamente.'
                    );
                }
                return $this->redirectToRoute('index');
            }
            else
                return $this->render('@App/error_page.html.twig');
        }
    }
}
