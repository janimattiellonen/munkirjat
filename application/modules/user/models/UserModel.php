<?php

class User_Model_UserModel extends \Munkirjat\Model
{
	protected $_entityClassName = '\Model\Entity\User';
	
	public function save(User_Form_UserForm $form)
	{
		$user = $this->findOrCreate($form->getValue('id') );
		
		$id = $user->getId();
		$saveMode = !isset($id);	

		$exclude = array();
		
		if(!$saveMode)
		{
			$values = $form->getValues();
			
			if(strlen($values['password']) == 0)
			{
				$exclude[] = 'password';
			}
			
			if(strlen($values['email']) == 0)
			{
				$exclude[] = 'email';
			}			
		}
		
		$user->fromArray($user->getEntityValues($form), $exclude);

		if(!in_array('password', $exclude) )
		{
			$password = $form->getValue('password');
			
			$salt = \Model\Service\AuthService::generateSalt();
			
			$user->setSalt($salt);
			$user->setPassword(\Model\Service\AuthService::hash($salt, $password) );
		}
		
		$id = $this->_save($user);
		
    	$as = new \Model\Service\AccountService();
    
	    if(!$as->getCodeFor($id) )
	    {
	    	$hash = $as->createCode($id);
	    	$as->saveCode($id, $hash);
	    }			
		
		return $id;
	}

	public function emailAddressAvailable($username, array $exclude = array() )
	{
		return $this->_getEntityRepository()->emailAddressAvailable($username, $exclude);
	}	
	
	public function usernameAvailable($username, array $exclude = array() )
	{
		return $this->_getEntityRepository()->usernameAvailable($username, $exclude);
	}
}