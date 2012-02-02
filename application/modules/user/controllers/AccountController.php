<?php
class User_AccountController extends Munkirjat_Controller_Action
{
	public function init()
	{
		parent::init();
		
		$this->_helper->getHelper('AjaxContext')
            ->addActionContext(array('username-available', 'email-available'), 'json')
            ->setAutoJsonSerialization(true)
            ->initContext();

        $this->view->inlineScript()->appendFile('/assets/js/user/account.js');  
        $this->view->headLink()->appendStylesheet('/assets/css/user/account.css');  
	}
	
	public function usernameAvailableAction()
	{
		$model = new User_Model_UserModel();
		
		$username = $this->_request->getParam('username');
		
		$id = $this->_request->getParam('id');
		
		if($username !== null)
		{
			$exclude = array();
			
			if(isset($id) && $id > 0)
			{
				$exclude['id'] = $id;
			}
			
			$form = new User_Form_UserForm();
			$form->populate($this->_request->getParams() );

			$form->getElement('csrf')->initCsrfToken();
			
			if($form->getElement('username')->isValid($username) )
			{
				$isAvailable = $model->usernameAvailable($username, $exclude);
				$message = $isAvailable ? 'Username is available' : 'Username is already taken';
			}
			else
			{
				$isAvailable = false;
				$message = implode(',', $form->getElement('username')->getMessages() );
			}
			
			return $this->_helper->json(array('available' => $isAvailable, 'message' => $message, 'hash' => $form->getElement('csrf')->getHash() ) );
		}
	}
	
	public function emailAvailableAction()
	{
		$model = new User_Model_UserModel();
		
		$email = $this->_request->getParam('email', null);
		
		$id = $this->_request->getParam('id');
		
		if($email !== null)
		{
			$exclude = array();
			
			if(isset($id) && $id > 0)
			{
				$exclude['id'] = $id;
			}			
			
			$form = new User_Form_UserForm();
			$form->populate($this->_request->getParams() );	

			$form->getElement('csrf')->initCsrfToken();
			
			if($form->getElement('email')->isValid($email) )
			{
				$isAvailable = $model->emailAddressAvailable($email, $exclude);
				$message = $isAvailable ? 'Email address is available' : 'Email address is already in use';
				
			}
			else
			{
				$isAvailable = false;
				$message = implode(',', $form->getElement('email')->getMessages() );
			}		
			
			return $this->_helper->json(array('available' => $isAvailable, 'message' => $message, 'hash' => $form->getElement('csrf') ->getHash() ) );
		}		
	}
	
    public function newAction()
    {
    	$this->view->headTitle('Create an account');
    	
        $form = new User_Form_UserForm();
        
        $form->setMethod('post')
        	->setAction($this->view->url(array(
        		'module' => 'user',
        		'controller' => 'account',
        		'action' => 'save',
        	), 'default') );
        
        $this->view->form = $form;	
    }    
    
	public function editAction()
    {
    	$this->view->headTitle('Edit user');
    	
        $form = new User_Form_UserForm();
        $form->setIsEditing();
    	        
        $form->setMethod('post')
        	->setAction($this->view->url(array(
        		'module' => 'user',
        		'controller' => 'account',
        		'action' => 'update',
        	), 'default') );
        
        $id = $this->_request->getParam('id');
        
        $model = new User_Model_UserModel();
        
        $user = $model->find($id);
        
        if($user == null)
        {
        	return $this->render('404');
        }

        $form->setValuesFromEntity($user);
        	
        $this->view->form = $form;	
    }
    
    public function saveAction()
    {
    	$form = new User_Form_UserForm();
    	
    	if(!$form->isValid($this->_request->getPost() ) )
    	{
    		$this->view->form = $form;
    		
    		return $this->render('new');
    	}
    	
    	$model = new User_Model_UserModel();
    	$userId = $model->save($form);
    	
    	$as = new \Model\Service\AccountService();
    	
    	$as->sendAccountVerificationEmail($userId);
    	
    	$this->_helper->redirector('account-created', 'account', 'user');
    	
    }    
    
    public function updateAction()
    {
    	if($this->_isCancelled() )
    	{
	    	$this->_helper->flashMessenger('Cancelled - nothing was saved');
    		$this->_helper->redirector('edit', 'account', 'user', array('id' => $this->_request->getPost('id') ) );      		
    	}
    	
    	$form = new User_Form_UserForm();
		$form->setIsEditing();
    	
    	if(!$form->isValid($this->_request->getPost() ) )
    	{
    		$this->view->form = $form;
    		
    		return $this->render('edit');
    	}
    	
    	$model = new User_Model_UserModel();
    	$userId = $model->save($form);
    	$this->_helper->flashMessenger('Account details saved');
    	$this->_helper->redirector('edit', 'account', 'user', array('id' => $form->getValue('id') ) );    	
    }
    
    public function accountCreatedAction()
    {
    	
    }
    
    public function activateAction()
    {
    	$hash = $this->_request->getParam('hash');
    	$username = $this->_request->getParam('username');
    	
        $as = new \Model\Service\AccountService();

        $this->view->activation_status = $as->activateAccount($username, $hash);
    }
    
    public function loginAction()
    {
        $form = new User_Form_LoginForm();
        
        if($this->_request->isPost() )
        {
            $username = $this->_request->getPost('username');
            $password = $this->_request->getPost('password');
            
            $am = new \Model\Service\AuthService();
            
            if($am->authenticate($username, $password) )
            {
                $this->_helper->flashMessenger($this->view->translate('You are now logged in') );
	            $this->_redirect($this->view->baseUrl() );
            }
            else
            {
        		$form->getElement('username')->addError($this->view->translate('The provided username and/or password was incorrect') );
            }
        }
        
        
        $this->view->form = $form;
    }
    
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity(); 
		Zend_Session::regenerateId();
		
        $this->_helper->flashMessenger($this->view->translate('You are now logged out.') );
        $this->_redirect($this->view->baseUrl() );
    }
}
