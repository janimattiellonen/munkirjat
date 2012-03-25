<?php
namespace Jme;

class Request
{
	/**
	 * Creates a unique identifier for values in the provided array.
	 * 
	 * @param array $params
	 * 
	 * @return string unique identifier
	 */
	public static function createIdentifierFromRequest(array $params)
	{
		ksort($params);
		
		$identifier = '';
		
		foreach($params as $key => $value)
		{
			$identifier .= "$key=$value|";
		}
		
		return md5(rtrim($identifier, '|') );
	}
}