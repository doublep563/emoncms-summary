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

  function summarise_controller()
  {
    global $mysqli,$user, $session, $route;

    require "Modules/summarise/summarise_model.php";
    include "Modules/summarise/summarise_model.php";
   // require "summarise_model.php";
    $summary = new Summary($mysqli);

    $userid = $session['userid'];
    if ($session['write'])
    {
      $list = $summary->check_table_exists();
      $result = view("Modules/summarise/summarise_list.php", array('summary_list'=>$list));
    }

    return array('content'=>$result);
  }
?>
