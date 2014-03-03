<?php


// no direct access
defined('EMONCMS_EXEC') or die('Restricted access');

class Summary
{
    private $mysqli;
       
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }


    public function check_table_exists()
    //TODO Change to boolean retrun type
    {
	  $list = array();
      $sql = "SHOW TABLES LIKE 'feed_summary_list' ";
      error_log('Mysql Query: ' + $sql);
      $result = $this->mysqli->query($sql);
            while ($row = $result->fetch_array())
      {
        $list[] = $row;
      }
      return $list;
   //   if (!$result){
    ///    error_log('Event Update: Mysql Error: ' + $this->mysqli->error);
    //  }
    }
    
        public function get_feeds()
        {
	  $list = array();	
      $sql = "SELECT id,name,tag from feeds ";
      error_log('Mysql Query: ' + $sql);
      $result = $this->mysqli->query($sql);
            while ($row = $result->fetch_array())
      {
        $list[] = $row;
      }
      return $list;
   //   if (!$result){
    ///    error_log('Event Update: Mysql Error: ' + $this->mysqli->error);
    //  }
    }
       public function get_feeds_summary_list()
        {
	  $list = array();	
      $sql = "SELECT * from feed_summary_list ";
      error_log('Mysql Query: ' + $sql);
      $result = $this->mysqli->query($sql);
            while ($row = $result->fetch_array())
      {
        $list[] = $row;
      }
      return $list;
   //   if (!$result){
    ///    error_log('Event Update: Mysql Error: ' + $this->mysqli->error);
    //  }
    }
	
    public function create($summaryid,$summaryname,$summarytag)
    {
      
	$feedid = "feed_".$summaryid;
	 $sqldaily = "INSERT INTO feed_summary(summary_date, feed_id, feed_name, summary_type, avg, max, min, count)
			select FROM_UNIXTIME(time,'%Y-%m-%d') as myDate, '$summaryid', '$summaryname', 'Daily', AVG(data),MAX(data),MIN(data),COUNT(*)
			from $feedid 
			GROUP BY myDate;";
	 $result = $this->mysqli->query($sqldaily);
	$sqlweek = "INSERT INTO feed_summary(summary_date, feed_id, feed_name, summary_type, avg, max, min, count)
			select FROM_UNIXTIME(time,'%Y-%m-%d') as myDate, '$summaryid', '$summaryname', 'Weekly', AVG(data),MAX(data),MIN(data),COUNT(*)
			from $feedid 
			GROUP BY YEAR(myDate), WEEK(myDate);";
	 $result1 = $this->mysqli->query($sqlweek);
	$sqlmonth = "INSERT INTO feed_summary(summary_date, feed_id, feed_name, summary_type, avg, max, min, count)
			select FROM_UNIXTIME(time,'%Y-%m-%d') as myDate, '$summaryid', '$summaryname', 'Monthly', AVG(data),MAX(data),MIN(data),COUNT(*)
			from $feedid 
			GROUP BY YEAR(myDate), MONTH(myDate);";
	 $result2 = $this->mysqli->query($sqlmonth);
	$sqlinsert = "INSERT INTO feed_summary_list(summary_date, feed_id, feed_name, summary_type)
			select max(summary_date), feed_id, feed_name, summary_type from feed_summary
			GROUP BY feed_id, summary_type;";
	$sqlupdate = "UPDATE feed_summary_list " .
				 "SET summary_tag = '$summarytag' ".
				 "where feed_id = $summaryid" ;
	 $result3 = $this->mysqli->query($sqlinsert);
	 $result4 = $this->mysqli->query($sqlupdate);
 
	  error_log("Mysql Query Result: ".$result3, 3, "/data/log/apache2/my-errors.log");
      if (!$result){
        error_log('Mysql Error: '.$this->mysqli->error, 3, "/data/log/apache2/my-errors.log" );
      }
    }

}
?>

