<?php
class Bookshelf_AuthorController extends Munkirjat_Controller_Action
{
	public function init()
	{
		parent::init();
		/*
		$this->_helper->getHelper('AjaxContext')
            ->addActionContext(array('find'), 'json')
            ->setAutoJsonSerialization(true)
            ->initContext();
*/
        //$this->view->inlineScript()->appendFile('/assets/js/user/account.js');  
        $this->view->headLink()->appendStylesheet('/assets/css/bookshelf/author.css');  
        
        $id = $this->_request->getParam('id');
        
        $this->view->createMode = !isset($id) || strlen($id) == 0; 
	}
		
	protected function _getForm()
	{
		$form = $this->getForm();
		
		$form->setMethod('post')
        	->setAction($this->view->url(array(
        		'module' => 'bookshelf',
        		'controller' => 'author',
        		'action' => 'save',
        	), 'default') );
        	
       return $form;
	}	
	
	public function newAction()
	{
	    $this->view->form = $this->_getForm();
	}
	
	public function editAction()
	{
	    $form = $this->_getForm();
		
        $id = $this->_request->getParam('id');
        
        $am = new Bookshelf_Model_AuthorModel();
        
        $author = $am->getAuthorForEdit($id, $form);

        if($author == null)
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
                $am = new Bookshelf_Model_AuthorModel();
                $author = $am->save($form);
                
                $this->_helper->flashMessenger($this->view->translate('Author details saved.') );
                
                $this->_redirect($this->view->baseUrl() . '/bookshelf/author/edit/id/' . $author->getId() );
            }
	    }
	    
	    return $this->render('new');
	}
	
	public function findAction()
	{
		return $this->_helper->json(
			$this->getModel()->findByNameForJson($this->_request->getParam('term') )
		);
	}
	
	public function browseAction()
	{
        /*
		$this->view->inlineScript()->appendFile('/assets/js/jquery.ui.sortable.js');  
		$this->view->inlineScript()->appendFile('/assets/js/jquery.ui.draggable.js');  
		
		$this->view->inlineScript()->appendFile('/assets/js/bsmselect.js');  
		
		$this->view->inlineScript()->appendFile('/assets/js/bsmselect.sortable.js');  
		
		$this->view->inlineScript()->appendFile('/assets/js/bsmselect.compatibility.js'); 
		$this->view->inlineScript()->appendFile('/assets/js/Jme/selector.js'); 		
		$this->view->inlineScript()->appendFile('/assets/js/bookshelf/author.js');
		*/
        //$this->view->headLink()->appendStylesheet('/assets/css/bsmselect.css');  
		
		
		$form = new Bookshelf_Form_AuthorSearchForm();
		$this->view->form = $form;
	}
    
    public function listAction()
    {
        $authors = $this->getModel()->listAll();
        
        if($authors && count($authors) > 0)
        {
            $this->view->authors = $authors;
        }
    }
}