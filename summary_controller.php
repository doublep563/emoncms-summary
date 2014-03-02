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

  function summary_controller()
  {
    global $mysqli,$user, $session, $route;

   // require "Modules/summarise/summarise_model.php";
    include "Modules/summary/summary_model.php";
   // require "summarise_model.php";
    $summary = new Summary($mysqli);

    $userid = $session['userid'];
    if ($session['write'])
    {
      $list = $summary->check_table_exists();
      $feeds = $summary->get_feeds();
      $feedsum = $summary->get_feeds_summary_list();
      $result = view("Modules/summary/summary_list.php", array('summary_list'=>$list),array('feeds'=>$feeds),array('feedsum'=>$feedsum));
    }

    return array('content'=>$result);
  }
?>
