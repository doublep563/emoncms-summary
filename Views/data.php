<?php

// get button click - Daily, Weekly or Monthly
$id = $_GET['id'];

$con = mysql_connect("localhost", "root", "ca1accp1");

if (!$con) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("emoncms", $con);

// $id is the summary period passed in above

$query = "SELECT UNIX_TIMESTAMP(summary_date) as summary_date, avg, min, max FROM `feed_summary` where summary_type='$id'";

$result = mysql_query($query);

$aAVGRows = $aMINRows = $aMAXRows = array();

while ($row = mysql_fetch_array($result)) {

    $date = date($row['summary_date'] * 1000);
    $aAVGRows[] = array($date, $row['avg']);
    $aMINRows[] = array($date, $row['min']);
    $aMAXRows[] = array($date, $row['max']);

}

$tJson = array();
//TODO Temperature needs to be determined from feed
$tJson['name'] = "Temperature";
$tJson['averages'] = $aAVGRows;
$tJson['minimums'] = $aMINRows;
$tJson['maximums'] = $aMAXRows;
echo json_encode($tJson, JSON_NUMERIC_CHECK);
