<?php
class Bookshelf_BookController extends Munkirjat_Controller_Action
{
	public function init()
	{
		parent::init();
		
		$this->view->inlineScript()->appendFile('/assets/js/bsmselect.js');  
		$this->view->inlineScript()->appendFile('/assets/js/bsmselect.sortable.js');  
		$this->view->inlineScript()->appendFile('/assets/js/bsmselect.compatibility.js');  
        $this->view->inlineScript()->appendFile('/assets/js/Jme/selector.js'); 
		$this->view->inlineScript()->appendFile('/assets/js/bookshelf/bookshelf.js'); 
         
        $this->view->headLink()->appendStylesheet('/assets/css/bsmselect.css');  
        
        $id = $this->_request->getParam('id');
        
        $this->view->createMode = !isset($id) || strlen($id) == 0; 
	}	
	
	protected function _getForm()
	{
		$form = $this->getForm();
		
		$form->setMethod('post')
        	->setAction($this->view->url(array(
        		'module' => 'bookshelf',
        		'controller' => 'book',
        		'action' => 'save',
        	), 'default') );
        	
       return $form;
	}
	
	public function newAction()
	{
        $form = $this->_getForm();
		
		$this->view->form = $form;
	}
	
	public function editAction()
	{
	    $form = $this->_getForm();
		
        $id = $this->_request->getParam('id');
        
        $bm = new Bookshelf_Model_BookModel();
        
        $book = $bm->getBookForEdit($id, $form);

        if($book == null)
        {
        	return $this->render('404');
        }
 
        $this->view->form = $form;	
		
		return $this->render('new');
	}
	
	public function saveAction()
	{
        $form = $this->_getForm();
	
	    $this->view->form = $form;
	    
	    if($this->_request->isPost() )
	    {
	        $post = $this->_request->getPost();
	        
	        if(isset($post['cancel']) )
	        {
	            $this->_helper->flashMessenger($this->view->translate('Action cancelled.') );
	            $this->_redirect($this->view->baseUrl() );
	        }
	        
            if($form->isValid($this->_request->getPost() ) )
            {
                $bm = new Bookshelf_Model_BookModel();
                $book = $bm->save($form);
                
                $this->_helper->flashMessenger($this->view->translate('Book details saved.') );
                
                $this->_redirect($this->view->baseUrl() . '/bookshelf/book/edit/id/' . $book->getId() );
            }
            else
            {
                $bm = new Bookshelf_Model_BookModel();
                $bm->populateCustom($form);
            }
	    }
	    
	    return $this->render('new');
	}
	
	public function listAction()
	{
	    $this->view->inlineScript()->appendFile('/assets/js/jquery.raty-1.4.0/js/jquery.raty.min.js'); 
	    
        $cache = $this->_helper->getHelper('cache')->getCache('content');

        $key = 'bookshelf_list_books_' . $this->_getRequestIdentifier($this->_request->getParams() );

        if(!($books = $cache->load($key) ) )
        {        
            $bm = new Bookshelf_Model_BookModel();

            $books = $bm->search($this->_request->getParams() );
            
            $cache->save($books);
        }
        
	    if(isset($books) )
	    {
	        $this->view->books = $books;
	    }
	    
	    return $this->render('list');
	}
	
	public function rateBookAction()
	{
	    $bm = new Bookshelf_Model_BookModel();
	    
	    $bookId = $this->_request->getParam('id');
	    
	    $result = array('status' => true);
	    
	    if(!$bm->rateBook($bookId, $this->_request->getParam('rating') ) )
	    {
	        $result['status'] = false;    
	    }
	    
        return $this->_helper->json($result);
	}
	
	public function rateUnratedBookAction()
	{
	    $this->view->inlineScript()->appendFile('/assets/js/jquery.raty-1.4.0/js/jquery.raty.min.js'); 
	    
	    $bm = new Bookshelf_Model_BookModel();
	    
	    $book = $bm->getOneUnratedBook();
	    
	    if($book)
	    {
	        $this->view->book = $book;
	    }
	    
	    if($this->_request->isXmlHttpRequest() )
	    {
    		$this->_helper->layout->disableLayout();
		    $this->_helper->viewRenderer->setNoRender(true);
		    
		    $this->view->mode = true;
	        return $this->render('partials/rate-book-table');
	    }
	    else
	    {
	        return $this->render('rate-book');
	    }
	}
	
	public function viewAction()
	{
	    $this->view->inlineScript()->appendFile('/assets/js/jquery.raty-1.4.0/js/jquery.raty.min.js'); 
	    
	    $bm = new Bookshelf_Model_BookModel();
	    
	    $book = $bm->find($this->_request->getParam('id') );
	    
	    if(!$book)
	    {
	        return $this->render('404');
	    }
	    
	    $this->view->book = $book;
	}
	
	public function removeAction()
	{
	    $bm = new Bookshelf_Model_BookModel();
	    
	    $book = $bm->find($this->_request->getParam('id') );
	    
	    if(!$book)
	    {
	        return $this->render('404');
	    }
	    
	    $bm->remove($book);
	    
	    $this->_helper->flashMessenger($this->view->translate('Book removed.') );
                
        $this->_redirect($this->view->baseUrl() );
	}
	
	public function indexAction()
	{
		
	}
	
	public function aboutAction()
	{
		
	}
	
}