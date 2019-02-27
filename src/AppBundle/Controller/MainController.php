<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use AppBundle\Entity\User;

class MainController extends Controller
{
    /**
     * Función utilizada para autenticarse en el sistema
     * @Route("/", name="index")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils) {
        // En caso de estar autenticado redirige a la ruta homepage
        if($this->container->get('security.token_storage')->getToken()->getUser() != "anon.")
            return $this->redirectToRoute('homepage');
        else {
            // Se obtienen los errores generados en el último intento de autenticación
            $error = $authenticationUtils->getLastAuthenticationError();
            
            // Con esta variable almacenamos el último nombre de usuario que se ha introducido
            // a fin de mostrarlo a modo de recordatorio
            $lastUsername = $authenticationUtils->getLastUsername();

            // Renderizamos la vista pasandole los parámetros deseados
            return $this->render('@App/main/homepage.html.twig', array(
                'last_username' => $lastUsername,
                'error'         => $error,
            ));
        }
    }

    /**
     * Función utilizada para cargar la vista de reinicio de contraseña
     * @Route("/reset_password", name="reset_password")
     */
    public function resetPasswordView() {
        // En caso de estar autenticado redirige a la ruta homepage
        if($this->container->get('security.token_storage')->getToken()->getUser() != "anon.")
            return $this->redirectToRoute('homepage');
        else 
            return $this->render('@App/main/reset_password.html.twig');
    }

    /**
     * Función encargada de reiniciar la contraseña de usuario y proporcionarla al mismo
     * @Route("/reset_password_form", name="reset_password_form", methods={"POST"})
     */
    public function resetPasswordAction(Request $request, 
        UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer) {

        $repository_user = $this->getDoctrine()->getRepository(User::class);
        $entityManager = $this->getDoctrine()->getManager();
        
        // Obtenemos el correo electrónico que ha introducido el usuario mediante una llamada POST 
        // del formulario
        $email = $request->request->get('email_reset_password');

        // Comprobamos que existe la variable a fin de evitar que se pueda acceder a la función 
        // introduciendo directamente la ruta en la barra de direcciones (lo que daría error sin dicha
        // comprobación)
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $repository_user->findOneBy(array('email' => $email)); // Objeto User poseedor del email
            if($user) { // En caso de que el correo electrónico no este registrado no se reiniciará la contraseña
                $random_password = md5(random_bytes(10)); // Generamos una nueva contraseña aleatoria
                $password = $passwordEncoder->encodePassword($user, $random_password); // y la ciframos

                // Se actualiza la contraseña del usuario en la base de datos
                $user->setPassword($password);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                // Por último, enviamos la contraseña al correo electrónico proporcionado
                $message = (new \Swift_Message())
                ->setSubject('Ha solicitado modificar su contraseña de Gaming Together')
                ->setFrom(['soporte.gamingtogether@gmail.com' => 'Soporte de Gaming Together'])
                ->setTo($email)
                ->setBody($this->renderView(
                    '@App/emails/reset_password_email.html.twig',
                    array('username' => $user->getUsername(), 'password' => $random_password)
                ),
                'text/html');
                $mailer->send($message);
            }
            $this->addFlash(
                'dark',
                'Hemos recibido su solicitud. Si el correo electrónico introducido se encuentra en nuestro sistema recibirá un mensaje con su nueva contraseña'
            );

            return $this->redirectToRoute('index');
        }
        else
            return $this->render('@App/error_page.html.twig');
    }
}