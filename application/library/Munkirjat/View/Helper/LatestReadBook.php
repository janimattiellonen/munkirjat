<?php

class Munkirjat_View_Helper_LatestReadBook extends Zend_View_Helper_Abstract 
{
	public function latestReadBook()
	{
		$bm = new Bookshelf_Model_BookModel();
		
		$book = $bm->getLatestReadBook();
		
		if($book)
		{
        	return $this->view->partial('partials/latest-read-book.phtml', array('book' => $book) );		
		}
		
		return '';
	}
}