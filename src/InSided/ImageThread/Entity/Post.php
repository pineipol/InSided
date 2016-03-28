<?php

namespace InSided\ImageThread\Entity;

/**
 * @Entity @Table(name="posts")
 */
class Post
{
    /**
     * @var integer
     *
     * @Column(name="post_id", type="integer")
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;
    
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
     * @param string $title Post title
     * @return \InSided\ImageThread\Entity\Posts Post
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
     * Set path
     * 
     * @param string $path Post image path
     * @return \InSided\ImageThread\Entity\Posts Post
     */
    public function setPath($path) 
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Get thumb image path
     *
     * @return string
     */
    public function getThumbPath()
    {
        return pathinfo($this->path, PATHINFO_DIRNAME) . '/thumb_' . pathinfo($this->path, PATHINFO_BASENAME);
    }
}
