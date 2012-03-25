<?php

class Jme_View_Helper_U extends Zend_View_Helper_Abstract 
{
	public function u($url, $skipProcess = false)
	{
		$url = trim($url);
		
		if(!$skipProcess)
		{
			$url = ltrim($url, '/');
		}
		
		$baseUrl = $this->view->baseUrl();
		
		if(isset($url[2]) && $url[2] == '/')
		{
			$url = substr($url, 3, strlen($url) );
		}
		
		if(strlen($url) == 0 && !$skipProcess)
		{
			return $baseUrl;
		}
		
		if(!$skipProcess)
		{
			return $baseUrl . '/' . $url;
		}
		return $url; 
	}
}
