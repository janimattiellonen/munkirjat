<?php

class Jme_Form_Element_Hash extends Zend_Form_Element_Hash
{
    public function loadDefaultDecorators()
    {
    	parent::loadDefaultDecorators();
    	
        $this->removeDecorator('Label')
        	->addErrorMessage('Invalid form submission');
    }
}
