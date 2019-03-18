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
use AppBundle\Entity\GameGroupVote;
use AppBundle\Form\PostType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;


class HomeController extends Controller
{
    /**
     * Esta función generará la información para mostrar en la vista principal de la aplicación una vez
     * el usuario se ha autenticado
     * @Route("/home", name="homepage")
     */
    public function indexAction(Request $request)
    {
        date_default_timezone_set('Europe/Madrid');

        $repository_post = $this->getDoctrine()->getRepository(Post::class);
        $repository_following = $this->getDoctrine()->getRepository(Following::class);
        $repository_likes = $this->getDoctrine()->getRepository(PostLike::class);
        $repository_votes = $this->getDoctrine()->getRepository(GameGroupVote::class);
        
        $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();

        // Obtenemos las publicaciones realizadas por el usuario logueado y por los usuarios que
        // el mismo está siguiendo
        $query_post = $repository_post->findPostUserAndFollowing($logged_user);

        $query_numpost_user = $repository_post->getNumPostsUser($logged_user); // Número de publicaciones del usuario
        $query_numfollowing_user = $repository_following->getNumFollowingsUser($logged_user); // Número de usuarios que sigue
        $query_numfollowers_user = $repository_following->getNumFollowersUser($logged_user); // Número de seguidores que posee
        $query_puntuation = $repository_votes->getAverageVoteUser($logged_user->getId()); // Puntuación media que posee de los grupos
        $query_numlikes_user = $repository_likes->getNumPostUserHasLiked($logged_user); // Número de likes que ha realizado

        foreach($query_post as $post) {

            $datetime = $this->timeago($post->getDatetime()); // Tiempo que ha pasado desde que se realizó la publicación
            $likes = $repository_likes->getNumLikesPost($post); // Likes de la publicación
            $has_like = $repository_likes->getUserHasLikePost($post, $logged_user); // Con eso sabemos si el usuario le ha dado me gusta a la publicación
            $posts[] = array(
                'id' => $post->getId(),
                'user' => $post->getUser(),
                'text' => $post->getText(),
                'datetime' => $datetime,
                'image' => $post->getImage(),
                'likes' => $likes,
                'hasLike' => $has_like
            );
        }

        // Creamos el formulario que le permitirá al usuario añadir nuevas publicaciones
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($post);

        if($form->isSubmitted()) { // Si el formulario ha sido enviado
            
            if (count($errors) > 0) { // y contiene errores, se envía de nuevo a la vista con estos
                return $this->render('@App/home/index.html.twig', array(
                    'errors' => $errors, 'form' => $form->createView()
                ));
            } else { // en caso contrario se inserta en la base de datos

                // Imagen añadida a la publicación
                $file = $form["image"]->getData(); // obtenemos la imagen
                $ext = $file->guessExtension(); // obtenemos su extensión
                $file_name = time().".".$ext; // generamos un nombre único
                $file->move("uploads/posts/",$file_name); // y movemos la imagen al directorio determinado

                // Almacenamos la información de la publicación en la base de datos
                $user = $this->getUser();
                $post->setUser($user);
                $post->setDatetime(new \DateTime('now'));
                $post->setImage($file_name);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($post);
                $entityManager->flush();

                $this->get('session')->getFlashBag()->add('notice', 'Su publicación se ha creado correctamente');
                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('@App/home/index.html.twig', 
            array(
                'posts' => isset($posts)? $posts:null,
                'numposts' => isset($query_numpost_user) ? $query_numpost_user:0,
                'numfollowing' => isset($query_numfollowing_user) ? $query_numfollowing_user:0,
                'numfollowers' => isset($query_numfollowers_user) ? $query_numfollowers_user:0,
                'puntuation' => isset($query_puntuation) ? $query_puntuation:0,
                'numlikes' => $query_numlikes_user,
                'form' => $form->createView()));
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
     * Función utilizada para dar me gusta a una publicación
     * @Route("/home/likePost/{id_post}", name="like_post", options={"expose"=true})
     */
    public function likePost($id_post) {
        date_default_timezone_set('Europe/Madrid');
        $repository_post = $this->getDoctrine()->getRepository(Post::class);
        $repository_postlike = $this->getDoctrine()->getRepository(PostLike::class);

        // Publicación votada
        $post = $repository_post->findOneBy(array('id' => $id_post));

        if($post) { // Si se encuentra la publicación
            $postlike = $repository_postlike->findOneBy(array('post' => $id_post, 'user' => $this->getUser()->getId()));
            
            if(!$postlike) { // Y el usuario no le ha dado ya like, se almacena en la BD su votación
                $user = $this->getUser();

                $postlike = new PostLike();

                $postlike->setUser($user);
                $postlike->setPost($post);
                $postlike->setDatetime(new \Datetime('now'));

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($postlike);
                $entityManager->flush();
            }
                return new Response();
        }
        else // Si no encuentra la publicación nos aparece la página de error
            return $this->render('@App/error_page.html.twig');
    }

    /**
     * Función para quitar un me gusta de una publicación
     * @Route("/home/unlikePost/{id_post}", name="unlike_post", options={"expose"=true})
     */
    public function unlikePost($id_post) {
 
        $repository_post = $this->getDoctrine()->getRepository(Post::class);
        $repository_postlike = $this->getDoctrine()->getRepository(PostLike::class);

        $post = $repository_post->findOneBy(array('id' => $id_post));
        $user = $this->getUser();

        // Se detecta si el usuario le ha dado like anteriormente
        $postlike = $repository_postlike->findOneBy(array('post' => $post, 'user' => $user));

        if($postlike) { // En caso de que si, se elimina de la base de datos
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($postlike);
            $entityManager->flush();
            
            return new Response();
        }
        else // En caso contrario muestra la página de error
            return $this->render('@App/error_page.html.twig');
    }
}
