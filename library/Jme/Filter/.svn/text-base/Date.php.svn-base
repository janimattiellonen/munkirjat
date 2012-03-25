<?php

/**
 * Converts date value to a proper displayable format. Currently used formats are hard coded and not configurable.
 * 
 * Source format: YYYY-dd-mm
 * Target format: dd.mm.YYYY
 * 
 * 2009-10-20 -> 20.10.2009
 */
class Jme_Filter_Date implements Zend_Filter_Interface 
{
	/**
	 * @param string $value
	 * 
	 * @return string 
	 */
	public function filter($value) 
	{
		$value = trim($value);
		
		if($value == '')
		{
			return '';		
		}
		
		$date = strtotime($value);
		
		return date('d.m.Y', $date);
	}
}
