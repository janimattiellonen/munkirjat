<?php

class Jme_View_Helper_Language extends Zend_View_Helper_Abstract 
{
	public function language($languageCode)
	{
		 $languages = array(
		     'fi' => $this->view->translate('Finnish'),
		     'se' => $this->view->translate('Swedish'),
		     'en' => $this->view->translate('English'),
		 );
		 
		 return isset($languages[$languageCode]) ? $languages[$languageCode] : '';
	}
}
