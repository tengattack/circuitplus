<?php

/**
 *      [BioMiao] (C)2001-2099 BioMiao Committee.
 *      SUSTC-ShenZhen-B
 *
 *      $Id: class/bm/base.php 2013-06-13 11:04:00 Zhuoteng Peng $
 */

if(!defined('IN_BIOMIAO')) {
	exit('Access Denied');
}

abstract class bm_base
{
	private $_e;
	private $_m;

	public function __construct() {

	}

	public function __set($name, $value) {
		$setter='set'.$name;
		if(method_exists($this,$setter)) {
			return $this->$setter($value);
		} elseif($this->canGetProperty($name)) {
			throw new Exception('The property "'.get_class($this).'->'.$name.'" is readonly');
		} else {
			throw new Exception('The property "'.get_class($this).'->'.$name.'" is not defined');
		}
	}

	public function __get($name) {
		$getter='get'.$name;
		if(method_exists($this,$getter)) {
			return $this->$getter();
		} else {
			throw new Exception('The property "'.get_class($this).'->'.$name.'" is not defined');
		}
	}

	public function __call($name,$parameters) {
		throw new Exception('Class "'.get_class($this).'" does not have a method named "'.$name.'".');
	}

	public function canGetProperty($name)
	{
		return method_exists($this,'get'.$name);
	}

	public function canSetProperty($name)
	{
		return method_exists($this,'set'.$name);
	}

	public function __toString() {
		return get_class($this);
	}

}
?>