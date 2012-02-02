<?php

class Munkirjat_View_Helper_RecentlyRead extends Zend_View_Helper_Abstract 
{
	public function recentlyRead()
	{
		$bm = new Bookshelf_Model_BookModel();
		
		$books = $bm->getRecentlyReadBooks();
		
		if($books)
		{
        	return $this->view->partial('partials/book-list.phtml', array('books' => $books, 'title' => $this->view->translate('Recently read') ) );		
		}
		
		return '';
	}
}