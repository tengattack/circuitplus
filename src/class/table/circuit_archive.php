<?php

/**
 *      [BioMiao] (C)2009-2013 BioMiao Committee.
 *      SUSTC-ShenZhen-B
 *
 *      $Id: class/table/circuit_archive.php 2013-06-24 00:43:00 Zhuoteng Peng $
 */

if(!defined('IN_BIOMIAO')) {
	exit('Access Denied');
}

//extends table_circuit
class table_circuit_archive extends bm_table
{
	public function __construct() {

		$this->_table = 'circuit_archive';
		$this->_pk    = 'archive_id';
		$this->_pre_cache_key = 'circuit_archive_';

		parent::__construct();
	}

}

?>