<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="published", type="boolean")
     */
    private $published;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Veuillez saisir un titre d'article valide.")
     * @Assert\NotNull()
     * @Assert\Length(
     *     min="2",
     *     max="150",
     *     minMessage="Votre titre doit comporter au minimun {{ limit }} caractères.",
     *     maxMessage="Votre titre doit comporter au maximun{{ limit }} caractères."
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\Length(
     *     min="2",
     *     minMessage="Le contenu de votre article doit comporter au minimun {{ limit }} caractères."
     * )
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="imagePath", type="string", length=255, nullable=true)
     * @Assert\Image(
     *     maxSize="4M",
     *     allowPortrait = true,
     *     maxSizeMessage="Votre image doit ne peut pas faire plus de 4Mo."
     * )
     */
    private $imagePath;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publishedDate", type="datetime")
     */
    private $publishedDate;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set published
     *
     * @param string $published
     *
     * @return Post
     */
    public function setPublished($published)
    {
        $this->published = $published;
        return $this;
    }

    /**
     * Get published
     *
     * @return string
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set imagePath
     *
     * @param string $imagePath
     *
     * @return Post
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     *
     * @return Post
     */
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;
        return $this;
    }

    /**
     * Get publishedDate
     *
     * @return \DateTime
     */
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }
}