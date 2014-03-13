<?php

// no direct access
defined('EMONCMS_EXEC') or die('Restricted access');

function summary_controller() {
    global $mysqli, $user, $session, $route;

    error_log("    Controller Called", 3, "/data/log/apache2/my-errors.log");
    error_log("    " . $route -> format, 3, "/data/log/apache2/my-errors.log");
    error_log("    " . $route -> action, 3, "/data/log/apache2/my-errors.log");
    include "Modules/summary/summary_model.php";

    $summary = new Summary($mysqli);

    $summary_db = new Summary($mysqli);
    $summary_feed = new Summary($mysqli);
    $summary_feedsum = new Summary($mysqli);

    $userid = $session['userid'];

    if ($route -> format == 'html') {
        if ($route -> action == "view" && $session['write']) {
            $feedsumdata = $summary_db -> get_summary_data();
            $result = view("Modules/summary/Views/summary_view.php", array('feedsumdata' => $feedsumdata));

            error_log("route->action == view", 3, "/data/log/apache2/my-errors.log");
        }

        if ($route -> action == "list" && $session['write']) {
            $feeds = $summary_feed -> get_feeds();
            $list = $summary_db -> check_table_exists();
            $feedsum = $summary_feedsum -> get_feeds_summary_list();
            $result = view("Modules/summary/summary_list.php", array('feeds' => $feeds, 'summary_list' => $list, 'feedsum' => $feedsum));

            error_log("route->action == list", 3, "/data/log/apache2/my-errors.log");
        }

    }

    if ($route -> format == 'json') {
        if ($route -> action == 'create' && $session['write']) {
            $summaryid = intval(get('summaryid'));
            $summaryname = get('summaryname');
            $summarytag = get('summarytag');

            $summary -> create($summaryid, $summaryname, $summarytag);
            $result = "Summary Created";
        }

        if ($route -> action == 'test' && $session['write']) {
            $summaryid = intval(get('summaryid'));
            $summaryname = get('summaryname');
            $summarytag = get('summarytag');

            $result = view("Modules/summary/Views/index.php", array('summaryid' => $summaryid, 'summaryname' => $summaryname, 'summarytag' => $summarytag));

            //$output = print_r($avg,1);

        }

    }
    return array('content' => $result);
}
?>

