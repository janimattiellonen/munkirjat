<?php

class Bookshelf_Model_TagModel extends \Munkirjat\Model
{
	protected $_entityClassName = '\Model\Entity\Tag';
	
	public function getTagForEdit($tagId, Bookshelf_Form_TagForm $form)
	{
	    $tag = $this->find($tagId);
	    
	    if(!$tag)
	    {
	        return null;
	    }
	    
	    $form->setValuesFromEntity($tag);

	    return $tag;
	}		
	
	/**
	 * 
	 * @param Bookshelf_Form_GenreForm $form
	 * @return \Model\Entity\Genre
	 */
	/*
	public function save(Bookshelf_Form_GenreForm $form)
	{
		$genre = $this->findOrCreate($form->getValue('id') );
		
		$genre->fromArray($genre->getEntityValues($form) );
	    
		$this->_save($genre);
		
		return $genre;
	}
	*/
}

