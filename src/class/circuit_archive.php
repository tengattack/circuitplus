<?php

/**
 *      [BioMiao] (C)2009-2013 BioMiao Committee.
 *      SUSTC-ShenZhen-B
 *
 *      $Id: class/circuit_archive.php 2013-10-31 02:36 Zhuoteng Peng $
 */

if(!defined('IN_BIOMIAO')) {
  exit('Access Denied');
}

require_once libfile('inc/circuit');

class circuit_archive_ctl {

  function circuit_archive_ctl() {
  }


  function on_show() {
    global $_G;
    $idorname = trim(getgpc('id'));
    $circuit = false;
    if (is_numeric($idorname)) {
      $circuit = C::t('circuit_archive')->fetch(intval($idorname));
    } else {
      //$circuit = C::t('circuit_archive')->fetch_by_id($idorname);
    }
    if (!$circuit) {
      showmessage('circuit_notfound');
    }

    $circuit_id = $circuit['archive_id'];

    if ($circuit['subclass_id']) {
      $circuit['classification'] = C::t('classification')->get_parent_tree($circuit['subclass_id']);
    }

    $r = C::t('relationship_archive')->get_circuit_relationship($circuit_id);

    $circuit['chassis'] = C::t('term')->fetch($circuit['chassis_id']);
    $circuit['plasmids'] = C::t('term')->fetch_all($r['child'][RT_CIRCUIT_PLASMID]);

    $circuit['codingframe'] = array();
    //$circuit['codingframe'] = C::t('codingframe_archive')->fetch_all($r['child'][RT_CIRCUIT_CODINGFRAME]);

    $codingframe_ids = array();
    $codingframe_state_ids = array();
    foreach ($circuit['codingframe'] as $cf) {
      $codingframe_ids[] = $cf['codingframe_id'];
      $codingframe_state_ids[] = $cf['state_id'];
    }
    $codingframe_state = C::t('term')->fetch_all($codingframe_state_ids);

    $rbs = C::t('relationship_archive')->get_codingframe_relationship($codingframe_ids);
    $biobrick_ids = array();
    foreach ($rbs as $rbkey => $rb) {
      $biobrick_ids = array_merge($biobrick_ids, $rb['child'][RT_CODINGFRAME_BIOBRICK]);
    }
    $biobrick_ids = array_unique($biobrick_ids);
    $biobricks = array();
    //$biobricks = C::t('biobrick_archive')->fetch_all($biobrick_ids);

    $dnaproperty_ids = array();
    foreach ($biobricks as $bkey => $b) {
      $dnaproperty_ids[] = $b['dnaproperty_id'];
    }
    $dnaproperty_ids = array_unique($dnaproperty_ids);
    $dnaproperties = C::t('term')->fetch_all($dnaproperty_ids);
    foreach ($biobricks as $bkey => $b) {
      $biobricks[$bkey]['dnaproperty'] = $dnaproperties[$b['dnaproperty_id']];
    }

    foreach ($circuit['codingframe'] as $key => $cf) {
      $bs = array();
      foreach ($rbs as $rbkey => $rb) {
        if ($rb['parent_id'] == $cf['codingframe_id']) {
          foreach ($rb['child'][RT_CODINGFRAME_BIOBRICK] as $bidkey => $bid) {
            $bs[] = $biobricks[$bid];
          }
        }
      }
      $circuit['codingframe'][$key]['biobricks'] = $bs;
      $circuit['codingframe'][$key]['state'] = $codingframe_state[$cf['state_id']]['name'];
      $circuit['codingframe'][$key]['length'] = strlen($cf['sequence']);
    }

    $circuit['parts'] = C::t('term')->fetch_all($r['child'][RT_CIRCUIT_PARTS]);

    $circuit['tags'] = C::t('term')->fetch_all($r['child'][RT_CIRCUIT_TAG]);

    $circuit['regulation'] = array();
    //$circuit['regulation'] = C::t('regulation')->fetch_all_by_circuitid($circuit_id);

    if ($circuit['user_id']) {
      $circuit['user'] = getuserbyuid($circuit['user_id']);
    }

    $circuit['lgd'] = json_encode(circuit_ctl::build_lgd_data($circuit), JSON_UNESCAPED_UNICODE);

    $feedbacks = array();
    //$feedbacks = C::t('circuit_feedback')->fetch_all_by_circuitid($circuit_id);
    $circuit['feedback'] = array(
      'count' => count($feedbacks),
      'list' => $feedbacks
    );

    $users = array();
    $user_ids = array();
    foreach ($feedbacks as $fkey => $fb) {
      $user_ids[] = $fb['user_id'];
    }
    $user_ids = array_unique($user_ids);
    foreach ($user_ids as $ukey => $uid) {
      $users[$uid] = getuserbyuid($uid);
    }

    $circuit['in_archive'] = true;

    $navtitle = 'Archive - Circuit';
    $q = $circuit['id'];
    include template('circuit/show');
  }

  function on_upload_submit() {
    global $_G;

    $circuit = $_GET['circuit'];
    if ($circuit && $_GET['formhash'] == $_G['formhash']) {
      daddslashes($circuit);
      dhtmlspecialchars($circuit);
      $chassis_id = 0;
      $rating = 0;

      $circuit_archive_id = C::t('circuit_archive')->insert(array(
        'circuit_id' => 0,

        'id' => '',

        'name' => $circuit['name'],
        'author' => $circuit['author'],
        'user_id' => $_G['uid'],

        'rating' => $rating,

        'subclass_id' => $circuit['subclass_id'],
        'description' => $circuit['description'],
        
        'chassis_id' => $chassis_id,
        'input' => $circuit['input'],
        'output' => $circuit['output'],
        'result' => $circuit['result'],

        'reference' => $circuit['reference']
      ), true);

      if ($circuit_archive_id) {

        if ($circuit['tags']) {
          foreach ($circuit['tags'] as $tid) {
            $tid = intval($tid);
            if ($tid > 0) {
              C::t('relationship_archive')->insert(array(
                'type' => RT_CIRCUIT_TAG,
                'parent_id' => $circuit_archive_id,
                'child_id' => $tid,
                'order' => 0
              ));
            }
          }
        }

        showmessage('circuit_submit_success', '/circuit/archive/'.$circuit_archive_id);
      }
    }

    showmessage('circuit_submit_failed');
  }

  function on_upload($do) {
    global $_G;

    if ($do == 'submit') {
      $this->on_upload_submit();
      return;
    }

    $tags = C::t('term')->fetch_all_by_type(TT_TAG);
    $classifications = C::t('classification')->get_child_tree(0);

    $json_tags = json_encode($tags, JSON_UNESCAPED_UNICODE);
    $json_classifications = json_encode($classifications, JSON_UNESCAPED_UNICODE);

    $navtitle = 'Upload';
    include template('circuit/upload');
  }

}

?>