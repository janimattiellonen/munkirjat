<?php
namespace Model\Entity;

use Model\Entity;

/**
 * @Entity(repositoryClass="Model\Repository\GenreRepository")
 * @Table(name="genre")
 */
class Genre extends Entity
{
	/**
	 * @Column(name="id", type="integer")
	 * @Id
	 * @GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @Column(name="name", type="string", length=45)
	 */
	protected $name;
	
    /**
     * @ManyToMany(targetEntity="Book", mappedBy="genres")
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

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
    /**
     * Add a book.
     * @param \Model\Entity\Book $book
     * @return \Model\Entity\Genre 
     */
    public function addBook(Entity\Book $book)
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addGenre($this);
        }
        
        return $this;
    }
    
    /**
     * Add a book.
     * @param \Model\Entity\Book $book
     * @return \Model\Entity\Genre 
     */
    public function removeBook(Entity\Book $book)
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            $book->removeGenre($this);
        }
        
        return $this;
    }		
    
    public function getBooks()
    {
        return $this->books;
    }
}