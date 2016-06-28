<?php
namespace Cypress\Curry;

/**
 * This class is created simply to define a special type 
 * for the placeholder. As defining a constant, even 
 * a random one, could collide with other values.
 */
class Placeholder {
	private static $instance;
	private function __construct(){}
	public static function get()
	{
		if(static::$instance === null)
			static::$instance = new Placeholder;
		return static::$instance;
	}
	public function __toString(){
		return '__';
	}
}