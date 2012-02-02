<?php

class User_Form_UserForm extends Jme_Form
{

    public function init()
    {
    	$id = $this->createElement('hidden', 'id')
    		->setRequired(false)
    		->setDecorators(array(new Zend_Form_Decorator_ViewHelper() ) );
    	
    	$username = $this->createElement('text', 'username')
    			->setLabel('Username')
    			->setRequired(true)
    			->addValidator('NotEmpty', true, array('messages' => 'Username is required') );
    			
    	$username->addValidator(Jme_Validate_Doctrine_NoRecordExists::createValidator($username, '\Model\Entity\User', 'username', array('id' => 'id') ), true);
    			
    	$this->setWidthValidator($username, 3, 30);			
    
    	$password = $this->createElement('password', 'password')
    			->setLabel('Password')
    			->setRequired(true)
    			->addValidator('NotEmpty', true, array('messages' => 'Password is required') );
    			
    	$this->setWidthValidator($password, 5, 64);		
    	
		$firstname = $this->createElement('text', 'firstname')
					->setLabel('First name')
					->addValidators(array(
						array('notEmpty', true, array('messages' => 'First name is required') ),
						array('stringLength', false, array(1, 64) ),
					))
					->setRequired(true);			
					
		$lastname = $this->createElement('text', 'lastname')
					->setLabel('Last name')
					->addValidators(array(
						array('notEmpty', true, array('messages' => 'Last name is required') ),
						array('stringLength', false, array(1, 64) ),
					))
					->setRequired(true);		

		$email = $this->createElement('text', 'email')
					->setAttrib('size', 40)
					->setLabel('Email address')
					->addValidators(array(
						array('notEmpty', true, array('messages' => 'Email address is required') ),
						array('emailAddress', true, array() ),
					))
					->setRequired(true);
					
		$email->addValidator(Jme_Validate_Doctrine_NoRecordExists::createValidator($email, '\Model\Entity\User', 'email', array('id' => 'id') ) );						
					
		$emailValidator = new Zend_Validate_Identical('email');
		$emailValidator->setMessage('Emails do not match', Zend_Validate_Identical::NOT_SAME);
		
		
					
		$email2 = $this->createElement('text', 'email2')
					->setAttrib('size', 40)
					->setLabel('Retype email address')
					->addValidators(array(	
						array('notEmpty', true, array('messages' => 'Please retype your email address') ),
						array('emailAddress', true, array() ),
						array($emailValidator, true)
					))
					->setRequired(true);
		$email2->addValidator(Jme_Validate_Doctrine_NoRecordExists::createValidator($email2, '\Model\Entity\User', 'email', array('id' => 'id') ) );
					
		$csrf = $this->createElement('hash', 'csrf', array('salt' => 'oiu45iuhgdfkj') );		
					
		$cancel = $this->createCancelButton();			
        $submit = $this->createSubmitButton('submit', 'Save');
        
        $this->addElements(array(
        	$id,
        	$username,
        	$password,
        	$firstname,
        	$lastname,
        	$email,
        	$email2,  
        	$csrf,      	
        	$submit,
        	$cancel,
        ) );
        
        $this->createButtonGroup('buttons', array($submit, $cancel) );
        
        $this->_applyFilters();
    }
    
    public function setIsEditing($state = true)
    {
    	if($state)
    	{
	    	$this->getElement('password')->setRequired(false);
	    	$this->getElement('email')->setRequired(false);
	    	$this->getElement('email2')->setRequired(false);    		
    	}
    }
}

