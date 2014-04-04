<?php

// no direct access
defined('EMONCMS_EXEC') or die('Restricted access');

function summary_controller() {
    global $mysqli, $user, $session, $route;

    include "Modules/summary/summary_model.php";

    $summary = new Summary($mysqli);

    $userid = $session['userid'];

 
        if ($route -> action == "view" && $session['write']) {

            $summaryid = intval(get('summaryid'));
            $summary_tag = (get('summary_tag'));
            $feed_name = (get('feed_name'));
            $feedsumdata = $summary -> get_summary_data($summaryid, $summary_tag, $feed_name);
            $result = view("Modules/summary/Views/summary_view.php", array('feedsumdata' => $feedsumdata));

            //error_log("route->action == view" . $summaryid, 3, "/data/log/apache2/my-errors.log");
        }

        else if ($route -> action == "deletesum" && $session['write']) {

            $summaryid = intval(get('summaryid'));

            $deletedata = $summary -> delete($summaryid);
            
            $result = "Feed Summary Deleted";
            //error_log("route->action == update list" . $summaryid, 3, "/data/log/apache2/my-errors.log");
        }
        
        else if ($route -> action == "update" && $session['write']) {

            $summaryid = intval(get('summaryid'));
            $summary_date = (get('summary_date'));
            $summary_type = (get('summary_type'));
            $summary_name = (get('summary_name'));
            
            $update = $summary -> update($summaryid, $summary_date, $summary_type, $summary_name );
            
            $list = $summary -> check_table_exists();
            $feeds = $summary -> get_feeds();
            $feedsum = $summary -> get_feeds_summary_list();
            $feedsumlist = $summary -> get_feeds_summary_list_all();
            
            $result = view("Modules/summary/summary_list.php", array('feeds' => $feeds, 'summary_list' => $list, 'feedsum' => $feedsum, 'feedsumlist' => $feedsumlist));
               

            
        }

        else if ($route -> action == "list" && $session['write']) {
            $list = $summary -> check_table_exists();

            if (!$list) {
                $result = view("Modules/summary/summary_list.php", array('summary_list' => $list));
            } else {
                $feeds = $summary -> get_feeds();
                $feedsum = $summary -> get_feeds_summary_list();
                $feedsumlist = $summary -> get_feeds_summary_list_all();
                $result = view("Modules/summary/summary_list.php", array('feeds' => $feeds, 'summary_list' => $list, 'feedsum' => $feedsum, 'feedsumlist' => $feedsumlist));
            }
            //error_log("route->action == list", 3, "/data/log/apache2/my-errors.log");
        }




        else if ($route -> action == 'createsum' && $session['write']) {
            $summaryid = intval(get('summaryid'));
            $summaryname = get('summaryname');
            $summarytag = get('summarytag');

            $summary -> create($summaryid, $summaryname, $summarytag);

            $result = "Summary Created";
        }

         else if ($session['write']) {
            $list = $summary -> check_table_exists();

            if (!$list) {
                $result = view("Modules/summary/summary_list.php", array('summary_list' => $list));
            } else {
                $feeds = $summary -> get_feeds();
                $feedsum = $summary -> get_feeds_summary_list();
                $feedsumlist = $summary -> get_feeds_summary_list_all();
                $result = view("Modules/summary/summary_list.php", array('feeds' => $feeds, 'summary_list' => $list, 'feedsum' => $feedsum, 'feedsumlist' => $feedsumlist));
            }
           
        }

  
    return array('content' => $result);
}
?>

