<?php

class Jme_View_Helper_LinkTo extends Zend_View_Helper_Abstract 
{
	/**
	 * Generates an <a> element
	 *
	 * @param string $text
	 * @param string $path
	 * @param array $options (accepted keys: skip_process, id, class, title, html)
	 * - skip_process (true/false): If true then the provided url is considered as working and will not be modified
	 * - id: html attribute
	 * - class: html attribute. Example: 'foo' and 'foo bar'
	 * - title: html attribute
	 * - html (true/false): If true then $text is assumed to contain html and will not be modified (DANGEROUS!)
	 * 
	 * @return string 
	 */
	public function linkTo($text, $path, array $options = array() )
	{
		$link = '<a';
		
		if(strpos($path, 'http://') !== 0)
		{
			$path = $this->view->u($path, isset($options['skip_process']) && $options['skip_process'] == true);
		}
		
		if(isset($options['id']) )
		{
			$link .= ' id="' . htmlentities($options['id']) . '"';	
		}
		
		if(isset($options['class']) )
		{
			$link .= $this->_appendClass($options['class']);
		}
		
		if(isset($options['title']) )
		{
			$link .= $this->_appendTitle($options['title']);
		}
		
		$content = null;
		
		if(isset($options['html']) && $options['html'] == true)
		{
			$content = $text;
		}
		else 
		{
			$content = $this->view->escape($text);
			
			$content = $this->view->translate($content);
		}
		
		$link .= ' href="' . $path . '">' . $content . '</a>';
		
		return $link;
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
