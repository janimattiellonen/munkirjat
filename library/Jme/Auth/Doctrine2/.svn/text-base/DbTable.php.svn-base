<?php

use Model;
class Jme_Auth_Doctrine2_DbTable implements Zend_Auth_Adapter_Interface
{
	private $_authenticateResultInfo;
	
	private $_tableName;
	
	private $_identityColumn;
	
	private $_credentialColumn;
	
	private $_credentialTreatment;
	
	private $_identity;
	
	private $_credential;
	
	private $_resultRow;
	
	public function __construct($tableName = null, $identityColumn = null, $credentialColumn = null, $credentialTreatment = null)
	{
        if (null !== $tableName) 
        {
            $this->setTableName($tableName);
        }

        if (null !== $identityColumn) 
        {
            $this->setIdentityColumn($identityColumn);
        }

        if (null !== $credentialColumn) 
        {
            $this->setCredentialColumn($credentialColumn);
        }

        if (null !== $credentialTreatment) 
        {
            $this->setCredentialTreatment($credentialTreatment);
        }		
	}
    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        $em = \Model\Service::getEntityManager();
        
    	try
    	{
    		$this->_authenticateSetup();
    		$table = Doctrine_Core::getTable(ucfirst($this->_tableName) );
    		
    		$q = $table->createQuery();
    		
    		$credentialColumn = $this->_credentialColumn;
    		$identityColumn = $this->_identityColumn;
    		$credentialTreatment = $this->_credentialTreatment;
    		
    		$tableName = $this->_tableName;

    		$q->from("$tableName t")
				->where("t.$identityColumn = ?", $this->_identity)
				->addWhere("t.$credentialColumn = $credentialTreatment", $this->_credential);
				
    		$result = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);			
    				
   	       	if ( ($authResult = $this->_authenticateValidateResultset($result) ) instanceof Zend_Auth_Result) 
   	       	{
           		return $authResult;
        	}         
        	
        	$this->_resultRow = $result[0];
        	
	        $this->_authenticateResultInfo['code'] = Zend_Auth_Result::SUCCESS;
	        $this->_authenticateResultInfo['messages'][] = 'Authentication successful.';
			
	        return $this->_authenticateCreateAuthResult();
    	}
    	catch(Exception $e)
    	{
    		throw new Zend_Auth_Adapter_Exception('Failed to authenticate due to an internal error: ' . $e->getMessage() );  
    	}
    }
    
    /**
     * @throws Zend_Auth_Adapter_Exception - in the event that setup was not done properly
     * @return true
     */
    protected function _authenticateSetup()
    {
        $exception = null;

        if ($this->_tableName == '') {
            $exception = 'A table must be supplied for the Zend_Auth_Adapter_DbTable authentication adapter.';
        } elseif ($this->_identityColumn == '') {
            $exception = 'An identity column must be supplied for the Zend_Auth_Adapter_DbTable authentication adapter.';
        } elseif ($this->_credentialColumn == '') {
            $exception = 'A credential column must be supplied for the Zend_Auth_Adapter_DbTable authentication adapter.';
        } elseif ($this->_identity == '') {
            $exception = 'A value for the identity was not provided prior to authentication with Zend_Auth_Adapter_DbTable.';
        } elseif ($this->_credential === null) {
            $exception = 'A credential value was not provided prior to authentication with Zend_Auth_Adapter_DbTable.';
        }

        if (null !== $exception) {
            /**
             * @see Zend_Auth_Adapter_Exception
             */
            ###// require_once 'Zend/Auth/Adapter/Exception.php';
            throw new Zend_Auth_Adapter_Exception($exception);
        }

        $this->_authenticateResultInfo = array(
            'code'     => Zend_Auth_Result::FAILURE,
            'identity' => $this->_identity,
            'messages' => array()
            );

        return true;
    }    
    
    /**
     * _authenticateValidateResultSet() - This method attempts to make
     * certain that only one record was returned in the resultset
     *
     * @param array $resultIdentities
     * @return true|Zend_Auth_Result
     */
    protected function _authenticateValidateResultSet(array $resultIdentities)
    {

        if (count($resultIdentities) < 1) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            $this->_authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
            return $this->_authenticateCreateAuthResult();
        } elseif (count($resultIdentities) > 1) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS;
            $this->_authenticateResultInfo['messages'][] = 'More than one record matches the supplied identity.';
            return $this->_authenticateCreateAuthResult();
        }
        
        return true;
    } 

    /**
     * getResultRowObject() - Returns the result row as a stdClass object
     *
     * @param  string|array $returnColumns
     * @param  string|array $omitColumns
     * @return stdClass|boolean
     */
    public function getResultRowObject($returnColumns = null, $omitColumns = null)
    {
        if (!$this->_resultRow) {
        	
            return false;
        }
        $returnObject = new stdClass();

        if (null !== $returnColumns) {

            $availableColumns = array_keys($this->_resultRow);
            foreach ( (array) $returnColumns as $returnColumn) {
                if (in_array($returnColumn, $availableColumns)) {
                    $returnObject->{$returnColumn} = $this->_resultRow[$returnColumn];
                }
            }
            return $returnObject;

        } elseif (null !== $omitColumns) {

            $omitColumns = (array) $omitColumns;
            foreach ($this->_resultRow as $resultColumn => $resultValue) {
                if (!in_array($resultColumn, $omitColumns)) {
                    $returnObject->{$resultColumn} = $resultValue;
                }
            }
            return $returnObject;

        } else {

            foreach ($this->_resultRow as $resultColumn => $resultValue) {
                $returnObject->{$resultColumn} = $resultValue;
            }
            return $returnObject;

        }
    }    
    
    protected function _authenticateCreateAuthResult()
    {
        return new Zend_Auth_Result(
            $this->_authenticateResultInfo['code'],
            $this->_authenticateResultInfo['identity'],
            $this->_authenticateResultInfo['messages']
            );
    }    
    
    public function setTableName($tableName)
    {
    	$this->_tableName = $tableName;
    }
    
    public function setIdentityColumn($identityColumn)
    {
    	$this->_identityColumn = $identityColumn;
    }
    
    public function setCredentialColumn($credentialColumn)
    {
    	$this->_credentialColumn = $credentialColumn;
    }
    
    public function setCredentialTreatment($credentialTreatment)
    {
    	$this->_credentialTreatment = $credentialTreatment;
    }
    
    public function setIdentity($value)
    {
        $this->_identity = $value;
    }

    public function setCredential($credential)
    {
        $this->_credential = $credential;
    }    
}
