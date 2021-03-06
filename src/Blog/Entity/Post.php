<?php

namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;

/**
 * Blog Post entity
 *
 * @Entity(repositoryClass="PostRepository")
 * @HasLifecycleCallbacks
 * @Table(indexes={
 *    @Index(name="publication_date_idx", columns="publicationDate")
 * })
 */

class Post
{
    /**
     * @var int
     *
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @Column(type="string")
     */
    protected $title;

    /**
     * @var string
     *
     * @Column(type="text")
     */
    protected $body;

    /**
     * @var \DateTime
     *
     * @Column(type="datetime")
     */
    protected $publicationDate;

    /**
     * @var Comment[]
     *
     * @OneToMany(targetEntity="Comment", mappedBy="post")
     */
    protected $comments;

    /**
     * @var Tag[]
     *
     * @ManyToMany(
     *     targetEntity="Tag", inversedBy="posts", fetch="EAGER", cascade={"persist"}, orphanRemoval=true
     * )
     * @JoinTable(
     *      inverseJoinColumns={@JoinColumn(name="tag_name", referencedColumnName="name")}
     * )
     */
    protected $tags;

    /**
     * @var PostAuthor
     *
     * @ManyToOne(targetEntity="PostAuthor", inversedBy="posts")
     */
    protected $author;

    /**
     * Initializes collections
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
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
     * Set body
     *
     * @param string $body
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set publicationDate
     *
     * @param \DateTime $publicationDate
     * @return Post
     */
    public function setPublicationDate($publicationDate)
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * Get publicationDate
     *
     * @return \DateTime
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * Add comments
     *
     * @param Comment $comments
     * @return Post
     */
    public function addComment(Comment $comments)
    {
        $this->comments[] = $comments;
        $comments->setPost($this);

        return $this;
    }

    /**
     * Remove comments
     *
     * @param Comment $comments
     */
    public function removeComment(Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add tags
     *
     * @param \Blog\Entity\Tag $tags
     * @return Post
     */
    public function addTag(Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Blog\Entity\Tag $tags
     */
    public function removeTag(Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set author
     *
     * @param \Blog\Entity\PostAuthor $author
     * @return Post
     */
    public function setAuthor(PostAuthor $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Blog\Entity\PostAuthor
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets publication date to now at persist time
     *
     * @PrePersist
     * @PreUpdate
     */
    public function setPublicationDateOnPrePersist()
    {
        if (!$this->publicationDate) {
            $this->publicationDate = new \DateTime();
        }
    }
}
