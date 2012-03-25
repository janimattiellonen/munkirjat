<?php

/**
 * Simple decorator that adds a '*' if the field is required.
 *
 * Not configurable at this moment.
 */
class Jme_Form_Decorator_Label extends Zend_Form_Decorator_Label 
{
    public function __construct($options = null)
    {
		parent::__construct($options);
		
		$this->setReqSuffix(' *');
    }
}

?>
