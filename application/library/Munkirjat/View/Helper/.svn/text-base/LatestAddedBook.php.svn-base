<?php

class Munkirjat_View_Helper_LatestAddedBook extends Zend_View_Helper_Abstract 
{
	public function latestAddedBook()
	{
		$bm = new Bookshelf_Model_BookModel();
		
		$book = $bm->getLatestAddedBook();
		
		if($book)
		{
        	return $this->view->partial('partials/latest-added-book.phtml', array('book' => $book) );		
		}
		
		return '';
	}
}