<?php


  // no direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  function summary_controller()
  {
    global $mysqli,$user, $session, $route;

   
    include "Modules/summary/summary_model.php";
	
	$summary = new Summary($mysqli);
   
    $summary_db = new Summary($mysqli);
    $summary_feed = new Summary($mysqli);
    $summary_feedsum = new Summary($mysqli);

    $userid = $session['userid'];
	
	 if ($route->action == 'create' && $session['write'])
    {
      $summaryid = intval(get('summaryid'));
      $summaryname = get('summaryname');
      $summarytag = get('summarytag');

      $summary->create($summaryid,$summaryname,$summarytag);
      $result = "Summary Created";
    }
	
    if ($session['write'])
    {
      $feeds = $summary_feed->get_feeds();
	  $list = $summary_db->check_table_exists();
      $feedsum = $summary_feedsum->get_feeds_summary_list();
      $result = view("Modules/summary/summary_list.php", array('feeds'=>$feeds, 'summary_list'=>$list, 'feedsum'=>$feedsum));
    }

    return array('content'=>$result);
  }
?>

