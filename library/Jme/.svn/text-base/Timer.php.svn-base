<?php
namespace Jme;

class Timer
{
	private static  $_start;
	private static $_end;
	
	public static function start()
	{
		self::$_end = 0;
		self::$_start = self::getTime();
	}
	
	public static function stop()
	{
		self::$_end = self::getTime();
		
		return self::duration();
	}	
	
	public static function duration()
	{
		return self::$_end - self::$_start;
	}
	
	private static function getTime()
	{
		list($usec, $sec) = explode(" ", microtime());
    	return ((float)$usec + (float)$sec);
	}
	
	
}