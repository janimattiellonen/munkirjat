<?php
namespace Model\Entity;

use Model\Entity;

/**
 * @Entity(repositoryClass="Model\Repository\AuthorRepository")
 * @Table(name="author")
 */
class Author extends Entity
{
	/**
	 * @Column(name="id", type="integer")
	 * @Id
	 * @GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @Column(name="firstname", type="string", length=45)
	 */
	protected $firstname;
	
	/**
	 * @Column(name="lastname", type="string", length=45)
	 */	
	protected $lastname;
	
    /**
     * @ManyToMany(targetEntity="Book", mappedBy="authors")
     */
	protected $books;
	
    public function __construct()
    {
        $this->books = new \Doctrine\Common\Collections\ArrayCollection();    
    }
	
	public function setId($id)
	{
		$this->id = $id;
	}

	public function setFirstname($pFirstname)
	{
		$this->firstname = $pFirstname;
	}

	public function setLastname($pLastname)
	{
		$this->lastname = $pLastname;
	}

	public function getFullname()
	{
	    return $this->firstname . ' ' . $this->lastname;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getFirstname()
	{
		return $this->firstname;
	}
	
	public function getLastname()
	{
		return $this->lastname;
	}
	
    /**
     * Add a book.
     * @param \Model\Entity\Book $book
     * @return \Model\Entity\Author 
     */
    public function addBook(Entity\Book $book)
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addAuthor($this);
        }
        
        return $this;
    }
    
    /**
     * Add a book.
     * @param \Model\Entity\Book $book
     * @return \Model\Entity\Author 
     */
    public function removeBook(Entity\Book $book)
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            $book->removeAuthor($this);
        }
        
        return $this;
    }		
    
    public function getBooks()
    {
        return $this->books;
    }
}