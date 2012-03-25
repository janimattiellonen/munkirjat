<?php

/**
 * Uses less decorators than Zend_Form_element_Hidden.
 */
class Jme_Form_Element_Hidden extends Zend_Form_Element_Hidden 
{
    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled() ) 
        {
            return;
        }

        $decorators = $this->getDecorators();
        
        if (empty($decorators) ) 
        {
            $this->addDecorator('ViewHelper');
        }
    }
}
