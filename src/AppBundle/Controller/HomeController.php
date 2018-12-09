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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends Controller
{
    /**
     * @Route("/home", name="homepage")
     */
    public function indexAction(Request $request)
    {
        date_default_timezone_set('Europe/Madrid');

        $repository_post = $this->getDoctrine()->getRepository(Post::class);
        $repository_following = $this->getDoctrine()->getRepository(Following::class);
        $repository_likes = $this->getDoctrine()->getRepository(PostLike::class);
        
        $logged_user = $this->container->get('security.token_storage')->getToken()->getUser();

        $query_post = $repository_post->findPostUserAndFollowing($logged_user);

        $query_numpost_user = $repository_post->getNumPostsUser($logged_user);
        $query_numfollowing_user = $repository_following->getNumFollowingsUser($logged_user);
        $query_numfollowers_user = $repository_following->getNumFollowersUser($logged_user);

        foreach($query_post as $post) {

            $datetime = $this->timeago($post->getDatetime());
            $likes = $repository_likes->getNumLikesPost($post);
            $has_like = $repository_likes->getUserHasLikePost($post, $logged_user);
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

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($post);

        if($form->isSubmitted()) {
            
            if (count($errors) > 0) {
                return $this->render('@App/index.html.twig', array(
                    'errors' => $errors, 'form' => $form->createView()
                ));
            } else {

                // upload file
                $file = $form["image"]->getData();
                $ext = $file->guessExtension();
                $file_name = time().".".$ext;
                $file->move("uploads",$file_name);

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

        if(isset($posts))
            return $this->render('@App/index.html.twig', array('posts' => $posts, 'numposts' => $query_numpost_user,
                'numfollowing' => $query_numfollowing_user, 'numfollowers' => $query_numfollowers_user,
                'form' => $form->createView()));
        else
            return $this->render('@App/index.html.twig', array("form" => $form->createView()));
    }

    public function timeago($datetime) {
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
     * @Route("/home/likePost/{id_post}", name="like_post", options={"expose"=true})
     */
    public function likePost($id_post) {
 
        $repository_post = $this->getDoctrine()->getRepository(Post::class);
        $repository_postlike = $this->getDoctrine()->getRepository(PostLike::class);

        $post = $repository_post->findOneBy(array('id' => $id_post));
        $user = $this->getUser();

        $postlike = new PostLike();

        $postlike->setUser($user);
        $postlike->setPost($post);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($postlike);
        $entityManager->flush();

        return new Response();
    }

    /**
     * @Route("/home/unlikePost/{id_post}", name="unlike_post", options={"expose"=true})
     */
    public function unlikePost($id_post) {
 
        $repository_post = $this->getDoctrine()->getRepository(Post::class);
        $repository_postlike = $this->getDoctrine()->getRepository(PostLike::class);

        $post = $repository_post->findOneBy(array('id' => $id_post));
        $user = $this->getUser();

        $postlike = $repository_postlike->findOneBy(array('post' => $post, 'user' => $user));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($postlike);
        $entityManager->flush();
        
        return new Response();
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
