<?php

class Munkirjat_View_Helper_Unread extends Zend_View_Helper_Abstract 
{
	public function unread()
	{
		$bm = new Bookshelf_Model_BookModel();
		
		$books = $bm->getUnreadBooks();
		
		if($books)
		{
		    $href = $this->view->linkTo('Unread', $this->view->baseUrl() . '/bookshelf/book/list/read/0');
		    
        	return $this->view->partial('partials/book-list.phtml', array('books' => $books, 'title' => $href ) );		
		}	
	}
}

?>