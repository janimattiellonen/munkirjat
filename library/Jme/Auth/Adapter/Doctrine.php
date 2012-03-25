<?php

namespace Jme\Auth\Adapter;


class Doctrine implements \Zend_Auth_Adapter_Interface
{
    protected $_em;

    protected $_entityClass;

    protected $_identityColumn;

    protected $_credentialColumn;

    protected $_identity;

    protected $_credential;

    protected $_applicationSalt;

    protected $_parameters;

    public function __construct(\Doctrine\ORM\EntityManager $em, $entityClass,
        $identityColumn, $credentialColumn, $credentialSaltColumn, $identity,
        $credential, $applicationSalt, array $parameters = array()
    ) {
        $this->_em                   = $em;
        $this->_entityClass          = $entityClass;
        $this->_identityColumn       = $identityColumn;
        $this->_credentialColumn     = $credentialColumn;
        $this->_credentialSaltColumn = $credentialSaltColumn;
        $this->_identity             = $identity;
        $this->_credential           = $credential;
        $this->_applicationSalt      = $applicationSalt;
        $this->_parameters           = $parameters;
    }

    /**
     * Performs an authentication attempt
     *
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
    	
        $qb = $this->_em->createQueryBuilder();
        $qb
            ->select('u')
            ->from($this->_entityClass, 'u')
            ->where(
                $qb->expr()->eq("u.{$this->_identityColumn}", ":identity")/*,
                $qb->expr()->eq("u.{$this->_credentialColumn}", "SHA1(CONCAT(:applicationSalt, CONCAT(:credential, u.{$this->_credentialSaltColumn})))"
                )*/
            );
        foreach ($this->_parameters as $key => $value) {
            if (is_array($value)) {
                $qb->andWhere($qb->expr()->in("u.{$key}", $value));
                unset($this->_parameters[$key]);
            } else {
                $qb->andWhere($qb->expr()->eq("u.{$key}", ":{$key}"));
            }
        }
        $query = $qb->getQuery();
        
        $query->setParameters(array_merge(
            array(
                'identity'        => $this->_identity,
                //'credential'      => $this->_credential,
                //'applicationSalt' => $this->_applicationSalt,
            ),
            $this->_parameters
        ));
        
        try {
            $user = $query->getSingleResult();
            
            $userSalt = $user->getSalt();
            $userPassword = $user->getPassword();

            if($userPassword === \Model\Service\AuthService::hash($user->getSalt(), $this->_credential) )
            {
	            return new \Zend_Auth_Result(\Zend_Auth_Result::SUCCESS, array(
    	            'identity'   => $user,
            	));
            }
        } 
        catch (\Doctrine\ORM\NoResultException $e) {
            return new \Zend_Auth_Result(\Zend_Auth_Result::FAILURE, array(
	        	'code' => \Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
	        	'messages' => array('No user with matching username was found.')
        	));
        }
        
        return new \Zend_Auth_Result(\Zend_Auth_Result::FAILURE, array(
        	'code' => \Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
        	'messages' => array('Supplied credential is invalid.')
        ));
    }
}
