<?php
namespace Model\Entity;

use Model\Entity;

/**
 * @Entity(repositoryClass="Model\Repository\TagRepository")
 * @Table(name="tag")
 */
class Tag extends Entity
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
     * @ManyToMany(targetEntity="Book", mappedBy="tags")
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
     * @return \Model\Entity\Tag 
     */
    public function addBook(Entity\Book $book)
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->addTag($this);
        }
        
        return $this;
    }
    
    /**
     * Add a book.
     * @param \Model\Entity\Book $book
     * @return \Model\Entity\Tag 
     */
    public function removeBook(Entity\Book $book)
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            $book->removeTag($this);
        }
        
        return $this;
    }		
    
    public function getBooks()
    {
        return $this->books;
    }
}