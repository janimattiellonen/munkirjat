<?php

class Munkirjat_View_Helper_FavouriteAuthors extends Zend_View_Helper_Abstract 
{
	public function favouriteAuthors()
	{
		$am = new Bookshelf_Model_AuthorModel();
		
		$authors = $am->getFavouriteAuthors();
		
		return $this->view->partial('partials/favourite-authors.phtml', array('authors' => $authors) );
		
	}
}

?>