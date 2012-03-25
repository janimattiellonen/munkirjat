<?php

class Bookshelf_Model_AuthorModel extends \Munkirjat\Model
{
	protected $_entityClassName = 'Model\Entity\Author';
	
	
	public function findByName($name)
	{
		$parts = \Model\Service\AuthorService::splitName($name);
		
		$firstname = isset($parts[0]) ? $parts[0] : null;
		$lastname = isset($parts[1]) ? $parts[1] : null;
		
		return $this->_getEntityRepository()->searchByName($firstname, $lastname);
	}
	
	public function findBynameForJson($name)
	{
		$results = $this->findByName($name);

		$authors = array();
		
		foreach($results as $author)
		{
			$authors[] = array('id' => $author->getId(), 'label' => $author->getFirstname() . ' ' . $author->getLastname() );
		}
		
		return $authors;
	}
	
	/**
	 * 
	 * @param Bookshelf_Form_AuthorForm $form
	 * @return \Model\Entity\Author
	 */
	public function save(Bookshelf_Form_AuthorForm $form)
	{
		$author = $this->findOrCreate($form->getValue('id') );
		
		$author->fromArray($author->getEntityValues($form) );
	    
		$this->_save($author);
		
		return $author;
	}

	public function getAuthorForEdit($authorId, Bookshelf_Form_AuthorForm $form)
	{
	    $author = $this->find($authorId);
	    
	    if(!$author)
	    {
	        return null;
	    }
	    
	    $form->setValuesFromEntity($author);

	    return $author;
	}	
	
	public function getFavouriteAuthors()
	{
	    return $this->_getEntityRepository()->getAuthors(3, 20);
	}
    
    public function listAll()
    {
        return $this->_getEntityRepository()->getAuthors(null, null);
    }
	
}