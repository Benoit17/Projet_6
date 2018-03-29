<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Services\BlogManager;
use App\Entity\Post;
use App\Form\PostType;


class DefaultController extends Controller

{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * @param AuthenticationUtils $authUtils
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/connexion", name="login")
     * @Method({"GET", "POST"})
     */
    public function login(AuthenticationUtils $authUtils, Request $request)
    {
        // récupération des erreurs si il y en a
        $error = $authUtils->getLastAuthenticationError();
        if($error !== null){
            $response = '<div class="alert alert-danger justify-content-center flash-msg-cnx">Nom d\'utilisateur ou mot de passe invalide</div>';
            return new Response($response, 400);
        }

        // dernier nom d'utilisateur saisie par l'utilisateur
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('default/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @param BlogManager $blogManager
     * @return Response
     *
     * @Route("/actualites", name="news")
     * @Method("GET")
     */
    public function news(BlogManager $blogManager)
    {
        // Récupération de tous les articles
        $posts = $blogManager->getPosts();

        // Récupération des 3 derniers articles rédigés
        $threeLastPost = $blogManager->getThreeLastPosts();

        return $this->render("default/news.html.twig", array(
            'posts' => $posts,
            'threeLastPost' => $threeLastPost,
        ));
    }

    /**
     * @param $id
     * @param BlogManager $blogManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/actualites/article/{id}", name="view-post")
     * @Method({"GET", "POST"})
     */
    public function post($id, BlogManager $blogManager, Request $request) {
        // Récupération de l'article via son id
        $post = $blogManager->getPost($id);

        // Récupération des 3 derniers articles rédigés
        $threeLastPost = $blogManager->getThreeLastPosts();

        return $this->render("default/post.html.twig", array(
            'post' => $post,
            'threeLastPost' => $threeLastPost,
        ));
    }

    /**
     * @param Request $request
     * @param BlogManager $blogManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     *
     * @Route("/admin", name="admin")
     * @Method({"GET", "POST"})
     */
    public function admin(Request $request, BlogManager $blogManager)
    {

        /* Utilisateurs */
        $user = $this->getUser();

        // Test si l'utilisateur est anonyme et redirige vers une page 403
        if($user === null) {
            throw new \Exception("Vous ne pouvez pas accéder à cette page", 403);
        }

        /* Articles */
        // Récupération de tous les articles
        $posts = $blogManager->getPosts();
        return $this->render('default/admin.html.twig', array(
            'posts' => $posts,
        ));
    }

    /**
     * @param BlogManager $blogManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/admin/add/article", name="add-post")
     * @Method({"GET", "POST"})
     */
    public function addPost(Request $request, BlogManager $blogManager) {
        $post = new Post();
        $createPostForm = $this->get('form.factory')->create(PostType::class, $post);
        $createPostForm->handleRequest($request);
        if ($createPostForm->isSubmitted() && $createPostForm->isValid()) {
            // Enregistrement du nouvel article
            $blogManager->setPost($post);
            $this->addFlash(
                'success',
                'Votre article a été publié!'
            );
            // Redirect to admin home page
            return $this->redirectToRoute('admin');
        }
        return $this->render("default/admin_post.html.twig", array(
            'title' => 'Nouveau billet',
            'createPostForm' => $createPostForm->createView(),
        ));
    }

    /**
     * @param $id
     * @param BlogManager $blogManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/admin/edit/article/{id}", name="edit-post")
     * @Method({"GET", "POST"})
     */
    public function editPost($id, Request $request, BlogManager $blogManager) {
        // Récupération de l'article via son id
        $post = $blogManager->getPost($id);
        $createPostForm = $this->get('form.factory')->create(PostType::class, $post);
        $createPostForm->handleRequest($request);
        if ($createPostForm->isSubmitted() && $createPostForm->isValid()) {
            // Enregistrement du nouvel article
            $blogManager->setPost($post);
            $this->addFlash(
                'success',
                'Votre article a été édité!'
            );
            // Redirect to admin home page
            return $this->redirectToRoute('admin');
        }
        return $this->render("default/admin_post.html.twig", array(
            'title' => 'Edition billet',
            'createPostForm' => $createPostForm->createView(),
        ));
    }

    /**
     * @param $id
     * @param BlogManager $blogManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/admin/supp/article/{id}", name="delete-post")
     * @Method({"GET", "POST"})
     */
    public function deletePost($id, BlogManager $blogManager) {
        // Delete the billet
        $blogManager->deletePost($id);
        $this->addFlash(
            'success',
            'Votre article a été supprimé!'
        );
        // Redirect to admin home page
        return $this->redirectToRoute('admin');
    }
}
