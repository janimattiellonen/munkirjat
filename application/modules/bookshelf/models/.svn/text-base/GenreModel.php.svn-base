<?php

class Bookshelf_Model_GenreModel extends \Munkirjat\Model
{
	protected $_entityClassName = '\Model\Entity\Genre';
		
	public function getGenreForEdit($genreId, Bookshelf_Form_GenreForm $form)
	{
	    $genre = $this->find($genreId);
	    
	    if(!$genre)
	    {
	        return null;
	    }
	    
	    $form->setValuesFromEntity($genre);

	    return $genre;
	}		
	
	/**
	 * 
	 * @param Bookshelf_Form_GenreForm $form
	 * @return \Model\Entity\Genre
	 */
	public function save(Bookshelf_Form_GenreForm $form)
	{
		$genre = $this->findOrCreate($form->getValue('id') );
		
		$genre->fromArray($genre->getEntityValues($form) );
	    
		$this->_save($genre);
		
		return $genre;
	}
	
	public function getGenres()
	{
	    return $this->_getEntityRepository()->getGenres();
	}
}

