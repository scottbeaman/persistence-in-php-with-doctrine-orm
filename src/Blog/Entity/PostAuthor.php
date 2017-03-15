<?php

namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Column;

/**
 * Post author entity
 *
 * @Entity
 */
class PostAuthor extends Author
{
    /* @var string
     *
     * @Column(type="text", nullable=true)
     */
    protected $bio;

    /**
     * @var Post[]
     *
     * @OneToMany(targetEntity="Post", mappedBy="postAuthor")
     */
    protected $posts;

    /**
     * Initializes collections
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    /**
     * Set bio
     *
     * @param string $bio
     * @return Author
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add posts
     *
     * @param \Blog\Entity\Post $posts
     * @return PostAuthor
     */
    public function addPost(\Blog\Entity\Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Blog\Entity\Post $posts
     */
    public function removePost(\Blog\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }
}
