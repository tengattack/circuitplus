<?php

/**
 *      [BioMiao] (C)2009-2013 BioMiao Committee.
 *      SUSTC-ShenZhen-B
 *
 *      $Id: class/table/relationship.php 2013-06-24 00:43:00 Zhuoteng Peng $
 */

if(!defined('IN_BIOMIAO')) {
	exit('Access Denied');
}

require_once libfile('inc/circuit');

class table_relationship_archive extends table_relationship
{
	public function __construct() {
		parent::__construct(array(
			'table' => 'relationship_archive',
			'pk' => 'id',
			'pre_cache_key' => 'relationship_archive_'
		));
	}

}

?>