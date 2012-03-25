<?php

class Jme_View_Helper_Date extends Zend_View_Helper_Abstract 
{
	public function date($date, $format = 'd.m.Y H:i')
	{
		if($date instanceof \DateTime)
		{
		    return $date->format($format);
		}
	}
}
