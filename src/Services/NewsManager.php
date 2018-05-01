<?php
namespace App\Services;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Knp\Bundle\PaginatorBundle\KnpPaginatorBundle;
class NewsManager
{
    private $em;
    private $request;
    private $session;
    private $fileSystem;
    private $postsDirectory;
    private $paginator;
    public function __construct(EntityManagerInterface $em,
                                RequestStack $request,
                                SessionInterface $session,
                                Filesystem $filesystem,
                                $postsDirectory,
                                $paginator)
    {
        $this->em = $em;
        $this->request = $request;
        $this->session = $session;
        $this->fileSystem = $filesystem;
        $this->postsDirectory = $postsDirectory;
        $this->paginator = $paginator;
    }
    /* Gestion des articles */
    public function getPost($id) {
        // Récupération d'un article par son id
        $post = $this->em->getRepository('App:Post')->findOneBy(array('id' => $id));
        // Retourne l'article récupéré
        return $post;
    }
    public function getPosts() {
        // Récupération de tous les articles existant
        $post = $this->em->getRepository('App:Post')->findAll();
        // Retourne l'article récupéré
        return $post;
    }
    public function getThreeLastPosts() {
        $threeLastPosts = $this->em->getRepository('App:Post')
            ->findBy(
                array('published' => '1'),
                array('publishedDate' => 'desc'),
                3);
        return $threeLastPosts;
    }
    public function getPostsNumber() {
        // Récupération des commentaires signalés
        $postsNumber = $this->em->getRepository('App:Post')->getPostsNumber();
        // Retourne les commentaires
        return $postsNumber;
    }
    public function setPost(Post $post) {
        // Publication automatique de l'article
        $post->setPublished(1);
        // Ajout de la date de publication
        $post->setPublishedDate(new \DateTime());
        // Récupération de l'image sélectionnée si disponible
        $newFile = $post->getPicturePath();
        // Récupération du chemin du dossier de stockage
        $path = $this->postsDirectory;
        if ($newFile === null) {
            // Ajout de l'image par défault
            $post->setPicturePath('img/default/post_default.jpg');
        } else {
            // Renommage du fichier
            $fileName = md5(uniqid()).'.'.$newFile->guessExtension();
            // Déplacement du fichier dans le dossiers articles
            $newFile->move($path, $fileName);
            // Ecriture du nouveau chemin
            $filePath = "uploads/posts_files/".$fileName;
            // Association de l'image à l'article
            $post->setPicturePath($filePath);
        }
        // Sauvegarde du nouvel article
        $this->em->persist($post);
        // Enregistrement du nouvel article
        $this->em->flush();
    }
    public function deletePost($id) {
        // Récupération de la catégorie par son id
        $post = $this->getPost($id);
        // Vérification pour ne pas supprimer l'image pas défaut
        if ($post->getPicturePath() != 'img/default/post_default.jpg') {
            // Suppression de l'ancienne photo
            $this->fileSystem->remove(array($post->getPicturePath()));
        }
        // Supression de l'article
        $this->em->remove($post);
        $this->em->flush();
    }
    /* PAGINATEUR */
    /**
     * Pagine la liste de tous les articles
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function getPaginatedPostsList()
    {
        // récupère la liste des questions/réponses
        $postsList = $this->getPosts();
        // récupère le service knp paginator
        $paginator  = $this->paginator;
        // retourne les questions /réponse paginé selon la page passé en get
        return $paginator->paginate(
            $postsList/*$query*/, /* query NOT result */
            $this->request->getCurrentRequest()->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
    }
    
//    public function getPhotosPath() {
//        // Récupération des articles
//        $posts = $this->getPosts();
//        $photos = array();
//        foreach ($posts as $post) {
//            array_push($photos, $post->getImagePath());
//        }
//        return $photos;
//    }
}