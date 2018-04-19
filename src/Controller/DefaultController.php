<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Form\ContactType;
use App\Services\NewsManager;
use App\Services\MailManager;


class DefaultController extends Controller

{
    /**
     * @param Request $request
     * @param NewsManager $newsManager
     * @param Mailmanager $mailManager
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="homepage")
     */
    public function index(Request $request, NewsManager $newsManager, MailManager $mailManager)
    {
        // Récupération des 3 derniers articles rédigés
        $threeLastPosts = $newsManager->getThreeLastPosts();

        $contactForm = $this->get('form.factory')->create(ContactType::class);
        $contactForm->handlerequest($request);
        // Soumission du formulaire
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // Récupération des données du formulaire
            $data = $contactForm->getData();

            // Préparation de l'email et envoi
            $mailManager->sendMail($data);

            return $this->redirectToRoute('homepage');
        }
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'threeLastPosts' => $threeLastPosts,
            'contactForm' => $contactForm->createView()
        ));
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

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @param NewsManager $newsManager
     * @return Response
     *
     * @Route("/actualites", name="news")
     * @Method("GET")
     */
    public function news(NewsManager $newsManager)
    {
        // Récupération de tous les articles
        $posts = $newsManager->getPaginatedPostsList();

        // Récupération des 3 derniers articles rédigés
        $threeLastPosts = $newsManager->getThreeLastPosts();

        return $this->render("default/news.html.twig", array(
            'posts' => $posts,
            'threeLastPosts' => $threeLastPosts,
        ));
    }

    /**
     * @param $id
     * @param NewsManager $newsManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/actualites/article/{id}", name="view-post")
     * @Method({"GET", "POST"})
     */
    public function post($id, NewsManager $newsManager, Request $request) {
        // Récupération de l'article via son id
        $post = $newsManager->getPost($id);

        // Récupération des 3 derniers articles rédigés
        $threeLastPost = $newsManager->getThreeLastPosts();

        return $this->render("default/post.html.twig", array(
            'post' => $post,
            'threeLastPost' => $threeLastPost,
        ));
    }
    
    /**
     * @param Request $request
     * @return Response
     *
     *
     */
    public function contact(Request $request){

    }
}
