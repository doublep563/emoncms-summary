<?php
/*
 * Created on 27 Feb 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>

<?php if (!$summary_list) { ?>
<div class="alert alert-block">
<h4 class="alert-heading">No Summary tables detected</h4>
<p> To add the summary tables:</p>
<p>1) Go to Admin and Update & Check</p>
</div>
<?php } else { ?>
<div class="alert alert-block">
<h4 class="alert-heading">Get a list of feeds</h4>
<p> Select * from feeds:</p>
<h4 class="alert-heading">Get a list of summary feeds</h4>
<p> Select * from feed_summary_list:</p>
</div>
<?php } ?>