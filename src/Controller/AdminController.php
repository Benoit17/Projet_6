<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Services\NewsManager;
use App\Entity\Post;
use App\Form\PostType;


class AdminController extends Controller

{

    /**
     * @param Request $request
     * @param NewsManager $newsManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     * @Route("/admin", name="admin")
     * @Method({"GET", "POST"})
     */
    public function indexAdmin(Request $request, NewsManager $newsManager)
    {
        /* Articles */
        
        // Récupération de tous les articles
        $posts = $newsManager->getPaginatedPostsList();

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
            return $this->redirectToRoute('admin');
        }
        
        return $this->render('default/admin.html.twig', array(
            'title' => 'Administration',
            'createPostForm' => $createPostForm->createView(),
            'posts' => $posts
        ));
    }

    /*--------------------------------Articles--------------------------------*/

    /**
     * @param $id
     * @param Request $request
     * @param NewsManager $newsManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     * @Route("/admin/edit/article/{id}", name="edit-post")
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
            return $this->redirectToRoute('admin');
        }

        return $this->render('default/admin.html.twig', array(
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
     * @Route("/admin/supp/article/{id}", name="delete-post")
     * @Method({"GET", "POST"})
     */
    public function deletePost($id, NewsManager $newsManager) {
        // Delete the billet
        $newsManager->deletePost($id);
        $this->addFlash(
            'success',
            'Article supprimé!'
        );
        // Redirect to admin home page
        return $this->redirectToRoute('admin');
    }
}
