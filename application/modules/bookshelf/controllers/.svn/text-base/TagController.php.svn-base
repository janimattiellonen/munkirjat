<?php
class Bookshelf_TagController extends Munkirjat_Controller_Action
{
	public function init()
	{
		parent::init();
        
        $id = $this->_request->getParam('id');
        
        //$this->view->headLink()->appendStylesheet('/assets/css/bookshelf/tag.css');
        
        $this->view->createMode = !isset($id) || strlen($id) == 0; 
	}    
	
	protected function _getForm()
	{
		$form = $this->getForm();
		
		$form->setMethod('post')
        	->setAction($this->view->url(array(
        		'module' => 'bookshelf',
        		'controller' => 'tag',
        		'action' => 'save',
        	), 'default') );
        	
       return $form;
	}		
    
	public function findAction()
	{
		return $this->_helper->json(
			$this->getModel()->findByNameForJson($this->_request->getParam('term') )
		);
	}
	
	/*
	public function editAction()
	{
	    $form = $this->_getForm();
		
        $id = $this->_request->getParam('id');
        
        $am = new Bookshelf_Model_GenreModel();
        
        $author = $am->getGenreForEdit($id, $form);

        if($author == null)
        {
        	return $this->render('404');
        }
 
        $this->view->form = $form;	
		
		return $this->render('new');
	}
	
	public function listAction()
	{
	    $am = new Bookshelf_Model_GenreModel();
	    
	    $this->view->genres = $am->getGenres();
	}
	
	public function newAction()
	{
	    $this->view->form = $this->_getForm();
	    
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
                $am = new Bookshelf_Model_GenreModel();
                $genre = $am->save($form);
                
                $this->_helper->flashMessenger($this->view->translate('Genre details saved.') );
                
                $this->_redirect($this->view->baseUrl() . '/bookshelf/genre/edit/id/' . $genre->getId() );
            }
	    }
	    
	    return $this->render('new');
	}
	*/
}