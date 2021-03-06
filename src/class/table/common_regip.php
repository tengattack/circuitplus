<?php

/**
 *      [BioMiao] (C)2009-2013 BioMiao Committee.
 *      SUSTC-ShenZhen-B
 *
 *      $Id: class/table/common_regip.php 2013-06-14 09:10:00 Zhuoteng Peng $
 */

if(!defined('IN_BIOMIAO')) {
	exit('Access Denied');
}

class table_common_regip extends bm_table
{
	public function __construct() {

		$this->_table = 'common_regip';
		$this->_pk    = '';

		parent::__construct();
	}

	public function fetch_by_ip_dateline($clientip, $dateline) {
		return DB::fetch_first('SELECT count FROM %t WHERE ip=%s AND count>0 AND dateline>%d', array($this->_table, $clientip, $dateline));
	}

	public function count_by_ip_dateline($ctrlip, $dateline) {
		if(!empty($ctrlip)) {
			return DB::result_first('SELECT COUNT(*) FROM %t WHERE '.DB::field('ip', $ctrlip, 'like').' AND count=-1 AND dateline>%d  LIMIT 1', array($this->_table, $dateline));
		}
		return 0;
	}

	public function update_count_by_ip($clientip) {
		return DB::query('UPDATE %t SET count=count+1 WHERE ip=%s AND count>0', array($this->_table, $clientip));
	}

	public function delete_by_dateline($dateline) {
		return DB::query('DELETE FROM %t WHERE dateline<=%d', array($this->_table, $dateline), false, true);
	}

}

?>