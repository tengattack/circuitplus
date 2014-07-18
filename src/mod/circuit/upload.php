<?php

/**
 *      [BioMiao] (C)2009-2013 BioMiao Committee.
 *      SUSTC-ShenZhen-B
 *
 *      $Id: mod/circuit/upload.php 2013-06-14 9:01:00 Zhuoteng Peng $
 */
 
if(!defined('IN_BIOMIAO')) {
	exit('Access Denied');
}

require_once libfile('class/circuit_archive');

$ctl_obj = new circuit_archive_ctl();

$ctl_obj->setting = $_G['setting'];
$ctl_obj->template = 'circuit/'.$curmod;
$ctl_obj->on_upload($do);

?>