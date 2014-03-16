<?php
/*
 * Created on 27 Feb 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 $schema['feed_summary'] = array(
    'summary_date' => array('type' => 'date'),
    'feed_id' => array('type' => 'int(11)'),
    'feed_name' => array('type' => 'text'),
    'summary_type' => array('type' => 'text'),
    'min' => array('type' => 'DECIMAL(5,1)'),
    'max' => array('type' => 'DECIMAL(5,1)'),
    'avg' => array('type' => 'DECIMAL(5,1)'),
    'count' => array('type' => 'int(11)')
);
 $schema['feed_summary_list'] = array(
    'summary_date' => array('type' => 'date'),
    'feed_id' => array('type' => 'int(11)'),
    'feed_name' => array('type' => 'text'),
    'summary_tag' => array('type' => 'text'),
    'summary_type' => array('type' => 'text')
);
 
?>
