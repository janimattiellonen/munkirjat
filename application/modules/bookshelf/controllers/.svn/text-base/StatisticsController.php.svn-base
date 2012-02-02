<?php
class Bookshelf_StatisticsController extends Munkirjat_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function indexAction()
	{
	    $date = $this->_request->getParam('date', date('Y-m-n', time() ) );
	    
	    $prevMonth = new Zend_Date($date);
	    $prevMonth->sub(1, Zend_Date::MONTH);
	    
	    $nextMonth = new Zend_Date($date);
	    $nextMonth->add(1, Zend_Date::MONTH);
	    
	    $sm = new Bookshelf_Model_StatisticsModel();
	    $addedBookCount = $sm->getAddedBookCountBetween(strtotime($date) );
	    $languages = $sm->getBookCountByLanguages();
	    
	    $this->view->addedBookCount = $addedBookCount;
	    $this->view->prevMonth = $prevMonth->toString('YYYY-MM-dd');
	    $this->view->nextMonth = $nextMonth->toString('YYYY-MM-dd');
	    
	    $this->view->languages = $languages;
	    
	    $this->view->genres = $sm->getGenreDistribution();
	    
	}
}
