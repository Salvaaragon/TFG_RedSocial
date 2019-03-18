<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;
use AppBundle\Entity\PostLike;
use AppBundle\Entity\Following;
use AppBundle\Entity\User;
use AppBundle\Form\PostType;
use AppBundle\Form\UserType;
use AppBundle\Entity\GameGroupVote;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ProfileController extends Controller
{
    /**
     * Función que carga el perfil de un usuario, mostrando las publicaciones que el mismo ha realizado
     * @Route("/profile/{username}", name="profile", options={"expose"=true})
     */
    public function indexAction(Request $request, String $username) {
        $repository_post = $this->getDoctrine()->getRepository(Post::class);
        $repository_following = $this->getDoctrine()->getRepository(Following::class);
        $repository_likes = $this->getDoctrine()->getRepository(PostLike::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);
        $repository_votes = $this->getDoctrine()->getRepository(GameGroupVote::class);

        $user = $repository_user->findOneBy(array('username' => $username));

        if (!$user) { // En caso de no encontrar al usuario muestra un error de excepción
            throw $this->createNotFoundException('El usuario no existe');
        }

        $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();

        $query_post = $repository_post->findBy(array('user' => $user)); // Obtenemos todas las publicaciones del usuario

        $query_numpost_user = $repository_post->getNumPostsUser($user); // Número de publicaciones del usuario
        $query_numfollowing_user = $repository_following->getNumFollowingsUser($user); // Número de usuarios que sigue
        $query_numfollowers_user = $repository_following->getNumFollowersUser($user); // Número de seguidores
        $query_numlikes_user = $repository_likes->getNumPostUserHasLiked($user); // Número de likes que ha realizado
        $query_puntuation = $repository_votes->getAverageVoteUser($user->getId()); // Puntuación media de los grupos

        foreach($query_post as $post) {

            $datetime = $this->timeago($post->getDatetime()); // Obtenemos el tiempo transcurrido desde que se realizó el post
            $likes = $repository_likes->getNumLikesPost($post); // Número de likes de la publicación
            $has_like = $repository_likes->getUserHasLikePost($post, $logged_user); // Obtenemos si el usuario logueado ha dado like a la publicación
            $posts[] = array(
                'id' => $post->getId(),
                'user' => $user,
                'text' => $post->getText(),
                'datetime' => $datetime,
                'image' => $post->getImage(),
                'likes' => $likes,
                'hasLike' => $has_like
            );
        }

        return $this->render('@App/profile/profile.html.twig', array(
                'posts' => isset($posts) ? $posts : null, 
                'numposts' => isset($query_numpost_user) ? $query_numpost_user: 0,
                'numfollowing' => isset($query_numfollowing_user) ? $query_numfollowing_user : 0, 
                'numfollowers' => isset($query_numfollowers_user) ? $query_numfollowers_user : 0,
                'user' => $user,
                'numlikes' => $query_numlikes_user,
                'puntuation' => isset($query_puntuation) ? round($query_puntuation,2): 0));
    }

    /**
     * Función que nos permite calcular cuanto tiempo ha pasado desde que se realizó una publicación
     * para así mostrarlo en la misma
     */
    private function timeago($datetime) {
        date_default_timezone_set('Europe/Madrid');
        $timestamp = strtotime($datetime->format('d-m-Y H:i:s'));

        $strTime = array("segundo", "minuto", "hora", "dia", "mes", "año");
        $length = array("60","60","24","30","12","10");

        $currentTime = time();
        if($currentTime >= $timestamp) {
            $diff     = time()- $timestamp;
            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
            $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return "Hace " . $diff . " " . $strTime[$i] . "(s)";
        }
    }

    /**
     * Función que nos permite obtener la lista de seguidores de un usuario
     * @Route("/profile/followers/{username}", name="followers_user")
     */
    public function followersAction($username) {
        $repository_post = $this->getDoctrine()->getRepository(Post::class);
        $repository_following = $this->getDoctrine()->getRepository(Following::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);
        $repository_likes = $this->getDoctrine()->getRepository(PostLike::class);
        $repository_votes = $this->getDoctrine()->getRepository(GameGroupVote::class);

        $user = $repository_user->findOneBy(
            array('username' => $username)
        );

        // En caso de introducir un nombre de usuario inexistente en el sistema, muestra la página de error
        if($user) { 
            $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();

            // Al igual que anteriormente, obtenemos estos datos que se mostrarán en la parte superior
            $query_followers = $repository_following->findFollowersUser($user);
            $query_numfollowing_user = $repository_following->getNumFollowingsUser($user);
            $query_numpost_user = $repository_post->getNumPostsUser($user);
            $query_numlikes_user = $repository_likes->getNumPostUserHasLiked($user);

            $query_puntuation = $repository_votes->getAverageVoteUser($user->getId()); // Puntuación media que posee de los grupos

            foreach($query_followers as $follower_id) {
                $follower = $repository_user->find($follower_id['id_user']);
                $isFollow = $repository_following->getUserIsFollowing($logged_user, $follower); // Determinamos si el usuario autenticado sigue a este
                $followers[] = array(
                    'id' => $follower->getId(),
                    'username' => $follower->getUsername(),
                    'profileName' => $follower->getProfilename(),
                    'steam_id' => $follower->getSteamId(),
                    'xbox_id' => $follower->getXboxId(),
                    'psn_id' => $follower->getPsnId(),
                    'isFollowed' => $isFollow,
                    'image' => $follower->getImage(),
                );
            }

            return $this->render('@App/profile/followers.html.twig', 
                array(
                    'followers' => isset($followers) ? $followers : null, 
                    'numfollowers' => isset($followers) ? count($followers) : 0,
                    'numfollowings' => isset($query_numfollowing_user) ? $query_numfollowing_user : 0,
                    'numposts' => isset($query_numpost_user) ? $query_numpost_user : 0,
                    'user' => $user,
                    'numlikes' => $query_numlikes_user,
                    'puntuation' => isset($query_puntuation) ? round($query_puntuation,2):0));
        }
        else
            return $this->render('@App/error_page.html.twig');
    }

    /**
     * Función que nos permite obtener la lista de seguidos de un usuario
     * @Route("/profile/followings/{username}", name="followings_user")
     */
    public function followingsAction($username) {
        $repository_post = $this->getDoctrine()->getRepository(Post::class);
        $repository_following = $this->getDoctrine()->getRepository(Following::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);
        $repository_likes = $this->getDoctrine()->getRepository(PostLike::class);
        $repository_votes = $this->getDoctrine()->getRepository(GameGroupVote::class);

        $user = $repository_user->findOneBy(
            array('username' => $username)
        );

        // En caso de introducir un nombre de usuario inexistente en el sistema, muestra la página de error
        if($user) {
            $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();

            $query_followings = $repository_following->findFollowingsUser($user);
            $query_numfollower_user = $repository_following->getNumFollowersUser($user);
            $query_numlikes_user = $repository_likes->getNumPostUserHasLiked($user);
            $query_numpost_user = $repository_post->getNumPostsUser($user);

            $query_puntuation = $repository_votes->getAverageVoteUser($user->getId()); // Puntuación media que posee de los grupos

            // Al igual que anteriormente, obtenemos estos datos que se mostrarán en la parte superior
            foreach($query_followings as $following_id) {
                $following = $repository_user->find($following_id['id_user']);
                $isFollow = $repository_following->getUserIsFollowing($logged_user, $following); // Determinamos si el usuario autenticado sigue a este

                $followings[] = array(
                    'id' => $following->getId(),
                    'username' => $following->getUsername(),
                    'profileName' => $following->getProfilename(),
                    'steam_id' => $following->getSteamId(),
                    'xbox_id' => $following->getXboxId(),
                    'psn_id' => $following->getPsnId(),
                    'isFollowed' => $isFollow,
                    'image' => $following->getImage(),
                );
            }

            return $this->render('@App/profile/followings.html.twig', array(
                'followings' => isset($followings) ? $followings : null, 
                'numfollowings' => isset($followings) ? count($followings) : 0,
                'numfollowers' => isset($query_numfollower_user) ? $query_numfollower_user : 0,
                'numposts' => isset($query_numpost_user) ? $query_numpost_user : 0,
                'user' => $user,
                'numlikes' => $query_numlikes_user,
                'puntuation' => isset($query_puntuation) ? round($query_puntuation,2):0));
        }
        else
            return $this->render('@App/error_page.html.twig');
    }

    /**
     * @Route("/profile/likes/{username}", name="likes_user")
     */
    public function likesAction($username) {
        $repository_post = $this->getDoctrine()->getRepository(Post::class);
        $repository_following = $this->getDoctrine()->getRepository(Following::class);
        $repository_user = $this->getDoctrine()->getRepository(User::class);
        $repository_likes = $this->getDoctrine()->getRepository(PostLike::class);
        $repository_votes = $this->getDoctrine()->getRepository(GameGroupVote::class);

        $user = $repository_user->findOneBy(
            array('username' => $username)
        );
        
        // En caso de introducir un nombre de usuario inexistente en el sistema, muestra la página de error
        if($user) {
            $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();

            // Obtenemos las publicaciones votadas por el usuario
            $query_postslikedByUser = $repository_post->getPostsLikedByUser($user);

            $query_numfollowing_user = $repository_following->getNumFollowingsUser($user);
            $query_numfollowers_user = $repository_following->getNumFollowersUser($user);
            $query_numlikes_user = $repository_likes->getNumPostUserHasLiked($user);
            $query_numpost_user = $repository_post->getNumPostsUser($user);
            $query_puntuation = $repository_votes->getAverageVoteUser($user->getId());

            // y las almacenamos en un vector que le pasaremos a la vista
            foreach($query_postslikedByUser as $post) {
                
                $datetime = $this->timeago($post->getDatetime());
                $likes = $repository_likes->getNumLikesPost($post);

                $posts[] = array(
                    'id' => $post->getId(),
                    'user' => $user,
                    'text' => $post->getText(),
                    'datetime' => $datetime,
                    'image' => $post->getImage(),
                    'likes' => $likes,
                    'hasLike' => 'liked'
                );
            }

            return $this->render('@App/profile/likes.html.twig', array(
                    'posts' => isset($posts) ? $posts : null, 
                    'numposts' => $query_numpost_user,
                    'numfollowing' => $query_numfollowing_user, 
                    'numfollowers' => $query_numfollowers_user,
                    'user' => $user,
                    'numlikes' => $query_numlikes_user,
                    'puntuation' => round($query_puntuation,2)));
        }
        else
            return $this->render('@App/error_page.html.twig');
    }

    /**
     * Método que genera el campo de búsqueda
     */
    public function searchBarAction() {
        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class)
            ->getForm();

        return $this->render('@App/profile/searchBar.html.twig',
            array('form' => $form->createView()));
    }

    /**
     * @Route("/search", name="handleSearch", options={"expose"=true}, methods={"POST"})
     * Método para realizar la búsqueda
     * @param Request $request
     */
    public function handleSearch(Request $request) {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $request->get('form')['search'];

            $repository_user = $this->getDoctrine()->getRepository(User::class);
            $repository_following = $this->getDoctrine()->getRepository(Following::class);
            $query_users = $repository_user->getUsersByUsername($username);

            $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();
            
            // Obtenemos la lista de usuarios almacenándola en un array 
            foreach($query_users as $user) {

                // Determinamos si el usuario autenticado sigue a este
                $isFollow = $repository_following->getUserIsFollowing($logged_user, $user);

                $users[] = array(
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'profileName' => $user->getProfilename(),
                    'steam_id' => $user->getSteamId(),
                    'xbox_id' => $user->getXboxId(),
                    'psn_id' => $user->getPsnId(),
                    'isFollowed' => $isFollow,
                    'image' => $user->getImage(),
                );
            }

            return $this->render('@App/profile/search_view.html.twig', 
                array(
                    'users' => isset($users) ? $users: null, 
                    'numUsers' => isset($users) ? count($users) : 0));
        }
        else 
            return $this->render('@App/error_page.html.twig');
    }

    /**
     * @Route("/my_data_profile", name="my_data_profile")
     * Método para acceder a los datos de nuestro perfil de usuario
     */
    public function myDataProfileAction(Request $request) {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        return $this->render('@App/profile/data_profile.html.twig', array('user' => $user,
            'user_image' => $user->getImage()));
    }

    /**
     * @Route("/modify_profile", name="modify_profile")
     */
    public function modifyDataAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        // 1) build the form
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm(UserType::class, $user, array('type' => 'show'));

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if($form->isSubmitted()) { // Si se ha enviado el formulario
            if (count($errors) > 0) { // y posee errores, se devuelven a la vista
                return $this->render('@App/profile/modify_profile.html.twig', array(
                    'errors' => $errors, 'form' => $form->createView(),
                    'user_image' => $user->getImage()
                ));
            } else { // en caso contrario se modifican los datos del usuario
                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                if($user->getProfileName() == null) $user->setProfileName($user->getUsername());

                // 4) save the User!
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $this->addFlash(
                    'notice',
                    'Sus datos se han modificado correctamente.'
                );

                return $this->redirectToRoute('my_data_profile');
            }
        }

        return $this->render('@App/profile/modify_profile.html.twig', array('form' => $form->createView(),
            'user_image' => $user->getImage()));
    }

    /**
     * @Route("/change_image", name="change_image", options={"expose"=true}, methods={"POST"})
     * Método para cambiar la imagen de perfil
     */
    public function changeImage(Request $request) {

        $repository_user = $this->getDoctrine()->getRepository(User::class);
        $entityManager = $this->getDoctrine()->getManager();

        if($_SERVER['REQUEST_METHOD'] === 'POST') { // Esto es innecesario, ya lo controla @Route
            $image = $request->files->get('input_image');
            $id_user = $request->request->get('id_user');

            $user = $repository_user->find($id_user);

            if($user) { // Solo la cambiamos en caso de recibir un id de usuario existente

                $ext = $image->guessExtension(); // Obtenemos la extensión del fichero
                $file_name = time().".".$ext; // Creamos un nombre único
                $image->move("uploads/profile_images",$file_name); // Movemos el archivo a la carpeta de imágenes
                $user->setImage($file_name); // y sobreescribimos la misma en la base de datos
                $entityManager->flush();

                $this->addFlash(
                    'notice',
                    'Su imagen ha sido modificada correctamente.'
                );

                return $this->redirectToRoute('my_data_profile');
            }
            else
                return $this->render('@App/error_page.html.twig');
        }
        else
            return $this->render('@App/error_page.html.twig');
    }
}
