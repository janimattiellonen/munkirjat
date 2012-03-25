<?php
class Jme_Resource_Auth extends Zend_Application_Resource_ResourceAbstract
{
	const DEFAULT_REGISTRY_KEY = 'Jme_Resource_Auth';
	
	/**
	 * @var App_Auth_Doctrine_DbTable
	 */
	protected $_auth;
	
	public function init()
	{
		return $this->getAuth();	
	}
	
	public function getAuth()
	{
		if(empty($this->_auth) )
		{
			$options = $this->getOptions();
			
			$tableName = isset($options['table_name']) ? $options['table_name'] : 'users';
			$identityColumn = isset($options['identity_column']) ? $options['identity_column'] : 'username';
			$credentialColumn = isset($options['credential_column']) ? $options['credential_column'] : 'password';
			$saltColumn = isset($options['salt_column']) ? $options['salt_column'] : 'salt';
			$useSalt = isset($options['use_salt']) ? $options['use_salt'] : false;
			$staticSalt = isset($options['static_salt']) ? $options['static_salt'] : null;
			
			$this->_auth = new Jme_Auth_Doctrine2_DbTable($tableName, $identityColumn, $credentialColumn);
	        
			if(isset($options['credential_treatment']) )
			{
				$this->_auth->setCredentialTreatment($options['credential_treatment']);
			}
			
	        Zend_Registry::set(self::DEFAULT_REGISTRY_KEY, $this->_auth);
		}

		return $this->_auth;	
	}
}
