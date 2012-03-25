<?php

class Jme_Validate_Date extends Zend_Validate_Regex {
	
    public function __construct()
    {
    	parent::__construct('/^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4}$/');
    	
    	$this->_messageTemplates[self::NOT_MATCH] = 'The provided value is not a valid date. Valid date format: dd.mm.yyyy';
    }
}
