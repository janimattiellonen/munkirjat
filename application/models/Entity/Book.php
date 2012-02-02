<?php
namespace Model\Entity;

use Model\Entity;
use \Doctrine\Common\Collections\ArrayCollection;


/**
 * @Entity(repositoryClass="Model\Repository\BookRepository")
 * @Table(name="book")
 * @HasLifecycleCallbacks
 */
class Book extends Entity
{
	/**
	 * @Column(name="id", type="integer")
	 * @Id
	 * @GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @Column(name="title", type="string", length=128)
	 */
	protected $title;
	
	/**
	 * @Column(name="language_id", type="string", length=3)
	 */
	protected $language;
	
    /**
     * @ManyToMany(targetEntity="Author", inversedBy="books")
     * @JoinTable(name="book_author",
     * 		joinColumns={@JoinColumn(name="book_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@JoinColumn(name="author_id", referencedColumnName="id")}
     * )
     */	
	protected $authors;
	
    /**
     * @ManyToMany(targetEntity="Genre", inversedBy="books")
     * @JoinTable(name="book_genre",
     * 		joinColumns={@JoinColumn(name="book_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@JoinColumn(name="genre_id", referencedColumnName="id")}
     * )
     */	
	protected $genres;	
	
    /**
     * @ManyToMany(targetEntity="Tag", inversedBy="books")
     * @JoinTable(name="book_tag",
     * 		joinColumns={@JoinColumn(name="book_id", referencedColumnName="id")},
     * 		inverseJoinColumns={@JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */	
	protected $tags;
	
	/**
	 * @Column(name="page_count", type="integer", length=5)
	 */
	protected $pageCount;
	
	/**
	 * @Column(name="is_read", type="integer", length=1)
	 */
	protected $isRead;
	
	/**
	 * @Column(name="isbn", type="string", length=40)
	 */	
	protected $isbn;
	
	/**
	 * @Column(name="created_at", type="datetime")
	 */
	protected $created;
	
	/**
	 * @Column(name="updated_at", type="datetime")
	 */
	protected $updated;
	
	/**
	 * @Column(name="started_reading", type="datetime")
	 */
	protected $startedReading;
	
	/**
	 * @Column(name="finished_reading", type="datetime")
	 */	
	protected $finishedReading;
	
	/**
	 * @Column(name="rating", type="float")
	 */
	protected $rating;
	
	public function __construct()
	{
	    $this->authors = new ArrayCollection();
	    $this->genres = new ArrayCollection();
	    $this->tags = new ArrayCollection();
	    $this->created = $this->updated = new \DateTime();
	    $this->rating = 0.0;
	}
	
	public function setId($id)
	{
		$this->id = $id;
	}	
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function setLanguage($language)
	{
		$this->language = $language;
	}
	
	public function getLanguage()
	{
		return $this->language;
	}	
	
    /**
     * Add an author.
     * @param \Model\Entity\Author $author
     * @return \Model\Entity\Book 
     */
    public function addAuthor(Entity\Author $author)
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
            $author->addBook($this);
        }
        
        return $this;
    }
    
    public function removeAuthors()
    {
        foreach($this->authors as $author)
        {
            $author->removeBook($this);
            $this->authors->removeElement($author);
        }
    }
    /**
     * Remove an author.
     * @param \Model\Entity\Author $author
     * @return \Model\Entity\Book 
     */
    public function removeAuthor(Entity\Author $author)
    {
        if ($this->authors->contains($author)) {
            $this->authors->removeElement($author);
            $author->removeBook($this);
        }
        
        return $this;
    }	
    
    public function getAuthors()
    {
        return $this->authors;
    }
    
    /**
     * @return array
     */
    public function getAuthorIds()
    {
        $array = array();
        
        foreach($this->getAuthors() as $author)
        {
            $array[] = $author->getId();
        }
        
        return $array;
    }
    
    public function getAuthorsAsString()
    {
        $str = '';
        
        foreach($this->getAuthors() as $author)
        {
            $str .= $author->getFullname() . ', ';    
        }
        
        return rtrim($str, ', ');
    }
    
    /**
     * Add a genre.
     * @param \Model\Entity\Genre $genre
     * @return \Model\Entity\Book 
     */
    public function addGenre(Entity\Genre $genre)
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
            $genre->addBook($this);
        }
        
        return $this;
    }
    
    public function removeGenres()
    {
        foreach($this->genres as $genre)
        {
            $genre->removeBook($this);
            $this->genres->removeElement($genre);
        }
    }
    /**
     * Remove a genre.
     * @param \Model\Entity\Genre $genre
     * @return \Model\Entity\Book 
     */
    public function removeGenre(Entity\Genre $genre)
    {
        if ($this->genres->contains($genre)) {
            $this->genres->removeElement($genre);
            $genre->removeBook($this);
        }
        
        return $this;
    }	
    
    public function getGenres()
    {
        return $this->genres;
    }    
    
    public function getGenresAsString()
    {
        $str = '';
        
        foreach($this->getGenres() as $genre)
        {
            $str .= $genre->getName() . ', ';    
        }
        
        return rtrim($str, ', ');
    }        
    
    /**
     * Add a genre.
     * @param \Model\Entity\Tag $tag
     * @return \Model\Entity\Book 
     */
    public function addTag(Entity\Tag $tag)
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addBook($this);
        }
        
        return $this;
    }
    
    public function removeTags()
    {
        foreach($this->tags as $tag)
        {
            $tag->removeBook($this);
            $this->tags->removeElement($tag);
        }
    }
    /**
     * Remove a genre.
     * @param \Model\Entity\Tag $tag
     * @return \Model\Entity\Book 
     */
    public function removeTag(Entity\Tag $tag)
    {
        if ($this->tags->contains($genre)) {
            $this->tags->removeElement($tag);
            $genre->removeBook($this);
        }
        
        return $this;
    }	
    
    public function getTags()
    {
        return $this->tags;
    }        
    
    public function getTagsAsString()
    {
        $str = '';
        
        foreach($this->getTags() as $tag)
        {
            $str .= $tag->getName() . ', ';    
        }
        
        return rtrim($str, ', ');
    }    
    
	public function setPageCount($pageCount)
	{
		$this->pageCount = $pageCount;
	}
	
	public function getPageCount()
	{
		return $this->pageCount;
	}
	
	public function setIsbn($isbn)
	{
		$this->isbn = $isbn;
	}
	
	public function getIsbn()
	{
		return $this->isbn;
	}
		
	
	public function setIsRead($isRead)
	{
		$this->isRead = $isRead;
	}
	
	public function isRead()
	{
		return $this->isRead;
	}	
	/*
	public function getIsRead()
	{
	    return $this->isRead;
	}
	*/
	
	/**
	 * @PreUpdate
	 */
	public function updated()
	{
	    $this->updated = new \DateTime();
	}
	
	/**
	 * @return \DateTime
	 */
	public function getCreated()
	{
	    return $this->created;
	}
	
	/**
	 * @return \DateTime
	 */
	public function getUpdated()
	{
	    return $this->updated;
	}
	
	public function setStartedReading($startedReading)
	{
	    if(isset($startedReading) )
	    {
		    $this->startedReading = new \DateTime($startedReading);
	    }
	    else
	    {
	        $this->startedReading = null;
	    }
	}
	
	public function getStartedReading()
	{
		return $this->startedReading;
	}	

	public function setFinishedReading($finishedReading)
	{
	    if(isset($finishedReading) )
	    {
		    $this->finishedReading = new \DateTime($finishedReading);
	    }
	    else
	    {
	        $this->finishedReading = null;
	    }
	}
	
	public function getFinishedReading()
	{
		return $this->finishedReading;
	}	
	
	public function setRating($rating)
	{
		$this->rating = $rating;
	}
	
	public function getRating()
	{
	    return $this->rating;
	}
}