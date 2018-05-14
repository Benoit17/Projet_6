<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Services\NewsManager;
use App\Entity\Post;
use App\Form\PostType;

class AdminController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/administration", name="admin")
     */
    public function indexAdmin()
    {
        // replace this example code with whatever you need
        return $this->render('default/admin.html.twig');
    }

    /*-------------------------------- Ajout artciles --------------------------------*/

    /**
     * @param Request $request
     * @param NewsManager $newsManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     * @Route("/administration/ecrire", name="write-post")
     * @Method({"GET", "POST"})
     */
    public function addPost(Request $request, NewsManager $newsManager)
    {
        /* Articles */
        
        $post = new Post();
        $createPostForm = $this->get('form.factory')->create(PostType::class, $post);
        $createPostForm->handleRequest($request);
        if ($createPostForm->isSubmitted() && $createPostForm->isValid()) {
            // Enregistrement du nouvel article
            $newsManager->setPost($post);
            $this->addFlash(
                'success',
                'Article publié!'
            );
            // Redirect to admin home page
            return $this->redirectToRoute('write-post');
        }

        return $this->render('default/admin/write_post/write.html.twig', array(
            'createPostForm' => $createPostForm->createView(),
        ));
    }

    /*-------------------------------- Gestion artciles --------------------------------*/

    /**
     * @param NewsManager $newsManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     * @Route("/administration/gestion_articles", name="manage-post")
     * @Method({"GET", "POST"})
     */
    public function managePost(NewsManager $newsManager)
    {
        /* Articles */
        // Récupération de tous les articles
        $posts = $newsManager->getPaginatedPostsList();
        // Récupération de l'article via son id
        
        return $this->render('default/admin/manage_post/manage.html.twig', array(
            'posts' => $posts
        ));
    }
    
    /**
     * @param $id
     * @param Request $request
     * @param NewsManager $newsManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     * @Route("/administration/gestion_articles/edition/article/{id}", name="edit-post")
     * @Method({"GET", "POST"})
     */
    public function editPost($id, Request $request, NewsManager $newsManager)
    {
        /* Articles */
        // Récupération de tous les articles
        $posts = $newsManager->getPaginatedPostsList();
        // Récupération de l'article via son id
        $post = $newsManager->getPost($id);
        $createPostForm = $this->get('form.factory')->create(PostType::class, $post);
        $createPostForm->handleRequest($request);
        if ($createPostForm->isSubmitted() && $createPostForm->isValid()) {
            // Enregistrement du nouvel article
            $newsManager->setPost($post);
            $this->addFlash(
                'success',
                'Article édité!'
            );
            // Redirect to admin home page
            return $this->redirectToRoute('manage-post');
        }
        return $this->render('default/admin/write_post/write.html.twig', array(
            'title' => 'Administration',
            'createPostForm' => $createPostForm->createView(),
            'posts' => $posts
        ));
    }

    /**
     * @param $id
     * @param NewsManager $newsManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/admin/gestion_articles/suppression/article/{id}", name="delete-post")
     * @Method({"GET", "POST"})
     */
    public function deletePost($id, NewsManager $newsManager)
    {
        // Delete the billet
        $newsManager->deletePost($id);
        $this->addFlash(
            'success',
            'Article supprimé!'
        );
        // Redirect to admin home page
        return $this->redirectToRoute('manage-post');
    }

}
