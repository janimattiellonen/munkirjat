<?php
namespace Model\Service;

/**
 * Provides an infrastructure for sending email messages.
 * 
 * @author jme
 *
 */
class AuthorService extends \Model\Service
{
    /**
     * @param string $name
     * @return array|null where index 0 is firstname and index 1 is lastname
     */
	public static function splitName($name)
	{
	    $parts = explode(' ', $name);
	    
	    $arr = array();

	    if(count($parts) == 0)
		{
			return null;
		}
		else if(count($parts) == 1)
		{
			$arr[0] = $parts[0];
			
		}
		else if(count($parts) == 2)
		{
			$arr[0] = $parts[0];
			$arr[0] = $parts[1];
		}		
		else
		{
			$lastname = array_pop($parts);
			$arr[0] = implode(' ', $parts);
			$arr[1] = $lastname;
		}	    
		
		return $arr;
	}
}