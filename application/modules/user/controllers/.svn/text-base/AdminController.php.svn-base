<?php

class User_AdminController extends Munkirjat_Controller_Action
{
    public function indexAction()
    {
    	
    }
    
    public function newAction()
    {
    	$this->view->headTitle('Create new user');
    	
        $form = new User_Form_UserForm();
        
        $form->setMethod('post')
        	->setAction($this->view->url(array(
        		'module' => 'user',
        		'controller' => 'user',
        		'action' => 'save',
        	), 'default') );
        
        $this->view->form = $form;	
    }    
    
    public function editAction()
    {
    	$this->view->headTitle('Edit user');
    	
        $form = new User_Form_UserForm();
        
        $form->setMethod('post')
        	->setAction($this->view->url(array(
        		'module' => 'user',
        		'controller' => 'user',
        		'action' => 'save',
        	), 'default') );
        
        $id = $this->_request->getParam('id');
        
        $user = $this->getModel()->find($id);
        
        if($user == null)
        {
        	return $this->render('404');
        }

        $form->setValuesFromEntity($user);
        	
        $this->view->form = $form;	
    }
    
    public function saveAction()
    {
    	$form = $this->getForm();
    	
    	if(!$form->isValid($this->_request->getPost() ) )
    	{
    		$this->view->form = $form;
    		
    		return $this->render('edit');
    	}
    	
    	$this->getModel()->save($form);
    	
    	$this->_helper->flashMessenger('User saved');
    	$this->_helper->redirector('index', 'user', 'user');
    }

}