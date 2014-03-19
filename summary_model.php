<?php

// no direct access
defined('EMONCMS_EXEC') or die('Restricted access');

class Summary {
    private $mysqli;

    public function __construct($mysqli) {
        $this -> mysqli = $mysqli;
    }

    public function check_table_exists()
    //TODO Change to boolean retrun type
    {
        $list = array();
        $sql = "SHOW TABLES LIKE 'feed_summary_list' ";
        error_log('Mysql Query: ' + $sql);
        $result = $this -> mysqli -> query($sql);
        while ($row = $result -> fetch_array()) {
            $list[] = $row;
        }
        return $list;
    }

    public function delete($summaryid) {
        // Delete Summaries
        $sql = "Delete from feed_summary where feed_id = '$summaryid'";
        $result = $this -> mysqli -> query($sql);
        // Delete Summaries List
        $sql1 = "Delete from feed_summary_list where feed_id = '$summaryid'";
        $result1 = $this -> mysqli -> query($sql1);

    }

    public function get_feeds() {
        $list = array();
        $sql = "SELECT id, name , tag FROM feeds WHERE feeds.id NOT IN (SELECT DISTINCT feed_id as id  FROM feed_summary_list);";
        $result = $this -> mysqli -> query($sql);
        while ($row = $result -> fetch_array()) {
            $list[] = $row;
        }
        return $list;
    }

    public function get_feeds_summary_list() {
        $list = array();
        $sql = "SELECT DISTINCT feed_id, feed_name,summary_tag from feed_summary_list;";
        $result = $this -> mysqli -> query($sql);
        while ($row = $result -> fetch_array()) {
            $list[] = $row;
        }
        return $list;
    }

    public function get_feeds_summary_list_all() {
        $list = array();
        $sql = "SELECT * from feed_summary_list;";
        $result = $this -> mysqli -> query($sql);
        while ($row = $result -> fetch_array()) {

            $list[] = $row;
        }
        //error_log("Mysql Query Result: ".$plist, 3, "/data/log/apache2/my-errors.log");
        return $list;
    }

    public function get_summary_data($summaryid, $summary_tag, $feed_name) {

        $dailysql = "SELECT UNIX_TIMESTAMP(summary_date) as summary_date, avg, min, max FROM `feed_summary` where summary_type = 'Daily' and feed_id = '$summaryid' ORDER BY summary_date";
        $weeksql = "SELECT UNIX_TIMESTAMP(summary_date) as summary_date, avg, min, max FROM `feed_summary` where summary_type = 'Weekly' and feed_id = '$summaryid' ORDER BY summary_date";
        $monthsql = "SELECT UNIX_TIMESTAMP(summary_date) as summary_date, avg, min, max FROM `feed_summary` where summary_type = 'Monthly' and feed_id = '$summaryid' ORDER BY summary_date";

        $dresult = $this -> mysqli -> query($dailysql);
        $wresult = $this -> mysqli -> query($weeksql);
        $mresult = $this -> mysqli -> query($monthsql);

        while ($row = $dresult -> fetch_array()) {

            $date = date($row['summary_date'] * 1000);
            $dAVGRows[] = array($date, $row['avg']);
            $dMINRows[] = array($date, $row['min']);
            $dMAXRows[] = array($date, $row['max']);
        }
        while ($row = $wresult -> fetch_array()) {

            $date = date($row['summary_date'] * 1000);
            $wAVGRows[] = array($date, $row['avg']);
            $wMINRows[] = array($date, $row['min']);
            $wMAXRows[] = array($date, $row['max']);
        }
        while ($row = $mresult -> fetch_array()) {

            $date = date($row['summary_date'] * 1000);
            $mAVGRows[] = array($date, $row['avg']);
            $mMINRows[] = array($date, $row['min']);
            $mMAXRows[] = array($date, $row['max']);
        }

        $arrValues = array();
        $arrValues[0] = $dAVGRows;
        $arrValues[1] = $dMINRows;
        $arrValues[2] = $dMAXRows;
        $arrValues[3] = $wAVGRows;
        $arrValues[4] = $wMINRows;
        $arrValues[5] = $wMAXRows;
        $arrValues[6] = $mAVGRows;
        $arrValues[7] = $mMINRows;
        $arrValues[8] = $mMAXRows;
        $arrValues[9] = $summary_tag;
        $arrValues[10] = $feed_name;
        return $arrValues;

    }

    public function create($summaryid, $summaryname, $summarytag) {

        $feedid = "feed_" . $summaryid;
        $sqldaily = "INSERT INTO feed_summary(summary_date, feed_id, feed_name, summary_type, avg, max, min, count)
            select FROM_UNIXTIME(time,'%Y-%m-%d') as myDate, '$summaryid', '$summaryname', 'Daily', AVG(data),MAX(data),MIN(data),COUNT(*)
            from (SELECT * from $feedid ORDER by time DESC) as temp WHERE DATE(FROM_UNIXTIME(time)) < DATE(CURDATE())
            GROUP BY myDate;";
        $result = $this -> mysqli -> query($sqldaily);
        $sqlweek = "INSERT INTO feed_summary(summary_date, feed_id, feed_name, summary_type, avg, max, min, count)
            select FROM_UNIXTIME(time,'%Y-%m-%d') as myDate, '$summaryid', '$summaryname', 'Weekly', AVG(data),MAX(data),MIN(data),COUNT(*)
            from (SELECT * from $feedid ORDER by time DESC) as temp WHERE YEARWEEK(FROM_UNIXTIME(time),7) < YEARWEEK(CURDATE(),7)
            GROUP BY YEAR(myDate), WEEK(myDate,7);";
        $result1 = $this -> mysqli -> query($sqlweek);
        $sqlmonth = "INSERT INTO feed_summary(summary_date, feed_id, feed_name, summary_type, avg, max, min, count)
            select FROM_UNIXTIME(time,'%Y-%m-%d') as myDate, '$summaryid', '$summaryname', 'Monthly', AVG(data),MAX(data),MIN(data),COUNT(*)
            from (SELECT * from $feedid ORDER by time DESC) as temp
            WHERE YEAR(FROM_UNIXTIME(time)) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
            AND MONTH(FROM_UNIXTIME(time)) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)
            GROUP BY YEAR(myDate), MONTH(myDate);";
        $result2 = $this -> mysqli -> query($sqlmonth);
        $sqlinsert = "INSERT INTO feed_summary_list(summary_date, feed_id, feed_name, summary_tag, summary_type)
            SELECT max(summary_date), feed_id, feed_name, '$summarytag', summary_type FROM feed_summary WHERE feed_id = '$summaryid'
            GROUP BY feed_id, summary_type;";

        $result3 = $this -> mysqli -> query($sqlinsert);

        /////////error_log("Mysql Query Result: ".$result3, 3, "/data/log/apache2/my-errors.log");
        if (!$result) {
            ///// error_log('Mysql Error: '.$this->mysqli->error, 3, "/data/log/apache2/my-errors.log" );
        }
    }

}
?>

