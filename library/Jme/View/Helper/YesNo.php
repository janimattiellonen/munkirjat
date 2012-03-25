<?php

class Jme_View_Helper_YesNo extends Zend_View_Helper_Abstract 
{
	/**
	 * 
	 * @return string 
	 */
	public function yesNo($text)
	{
		$filter = new App_Filter_YesNo();
		
		return $filter->filter($text);
	}
	
	/**
	 * @param mied $classes
	 */
	protected function _appendClass($classes)
	{
		if(!is_array($classes) )
		{
			$classes = array($classes);
		}
		
		if(count($classes) == 0)
		{
			return '';
		}
		
		$c = 0;
		$size = count($classes);
		$link = ' class="';
		
		foreach($classes as $class)
		{
			$link .= htmlentities($class);
	
			if($c < $size - 1)
			{
				$link .= ' ';
			}
			
			$c++;
		}
		
		$link .= '"';
		
		return $link;
	}
	
	/**
	 * @param string $text
	 */
	protected function _appendTitle($text)
	{
		$str = ' title="' . htmlentities($text) . '"';
		
		return $str;
	}
}

?>
