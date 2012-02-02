<?php

class Munkirjat_View_Helper_BookStats extends Zend_View_Helper_Abstract 
{
	public function bookStats()
	{
		$sm = new Bookshelf_Model_StatisticsModel();
		$stats = $sm->getBookStatistics();
		
		$this->view->bookStats = $stats;
		
       	return $this->view->render('partials/book-stats.phtml');		
	}
}