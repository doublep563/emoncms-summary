<?php
/*
 All Emoncms code is released under the GNU Affero General Public License.
 See COPYRIGHT.txt and LICENSE.txt.

 ---------------------------------------------------------------------
 Emoncms - open source energy visualisation
 Part of the OpenEnergyMonitor project:
 http://openenergymonitor.org
 */

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
      $sql = "SELECY id,name,tag from feeds ";
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
      $sql = "SELECY * feed_summary_list ";
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
}
?>

