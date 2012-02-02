<?php

class User_Form_LoginForm extends Jme_Form 
{
	public function init()
	{
		$this->setMethod(Zend_Form::METHOD_POST);
		$this->setAction('/login');
		
		$username = $this->createElement('text', 'username');
		$username->setLabel('Username');
		
		$password = $this->createElement('password', 'password');
		$password->setLabel('Password');
		
		$submit = $this->createSubmitButton('login', 'Login');
		$cancel = $this->createCancelButton();
		
		$this->addElement($username);
		$this->addElement($password);
		$this->addElement($submit);
		$this->addElement($cancel);
	}
}

