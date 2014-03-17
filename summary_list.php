<?php
global $path;
 ?>

<h2>Summaries</h2>

<p>Create and view feed summaries</p>

<?php if (!$summary_list) { ?>
<div class="alert alert-block">
<h4 class="alert-heading">No Summary tables detected</h4>
<p> To add the summary tables:</p>
<p>1) Go to Admin and Update & Check</p>
</div>

<?php } else { if ($feedsum > 0)  { ?>
<div class="alert alert-block">
<h4 class="alert-heading">Feeds with Summaries</h4>
</div>

<table class="table table-hover" style="">

  <?php foreach ($feedsum as $myfeedsum){ ?>
    <tr>
    <td><b><?php echo $myfeedsum['feed_id']; ?></b></td>
    <td><b><?php echo $myfeedsum['feed_name']; ?></b></td>
    <td><b><?php echo $myfeedsum['summary_tag']; ?></b></td>
    <td> <a href="<?php echo $path; ?>summary/view?summaryid=<?php echo $myfeedsum['feed_id']; ?>&summary_tag=<?php echo $myfeedsum['summary_tag']; ?>&feed_name=<?php echo $myfeedsum['feed_name']; ?>"  class="btn btn-info"><?php echo _('View'); ?></a></td>
       <td><div class="managesummary btn btn-info" 
            summaryid="<?php echo $myfeedsum['feed_id']; ?>"
            summaryname="<?php echo $myfeedsum['feed_name']; ?>"
            summarytag="<?php echo $myfeedsum['summary_tag']; ?>"

        >Manage</div></td>   
  </tr>
 
  <tr class="feed_id_row<?php echo $myfeedsum['feed_id']; ?>" style="display:none">
    <td><b></b></td>
    <td><b>Daily</b></td>
    <td><b>Last Updated:</b></td>
    <td><b>Status:</b></td>
  </tr>
  <tr class="feed_id_row<?php echo $myfeedsum['feed_id']; ?>" style="display:none">
    <td><b></b></td>
    <td><b>Weekly</b></td>
    <td><b>Last Updated:</b></td>
    <td><b>Status:</b></td>
  </tr>
    <tr class="feed_id_row<?php echo $myfeedsum['feed_id']; ?>" style="display:none">
    <td><b></b></td>
    <td><b>Monthly</b></td>
    <td><b>Last Updated:</b></td>
    <td><b>Status:</b></td>
  </tr>
    <tr align="right"  class="feed_id_row<?php echo $myfeedsum['feed_id']; ?>" style="display:none">
    <td><b></b></td>
    <td><b></b></td>
    <td><b></b></td>
    <td><b></b></td>
    <td> <a href="<?php echo $path; ?>summary/delete?summaryid=<?php echo $myfeedsum['feed_id']; ?>&summary_tag=<?php echo $myfeedsum['summary_tag']; ?>&feed_name=<?php echo $myfeedsum['feed_name']; ?>"  class="btn btn-info"><?php echo _('Delete'); ?></a></td>
  </tr>

  
  
  
  <?php } ?>
</table>

<?php } if ($feeds > 0)  { ?>

<div class="alert alert-block">
<h4 class="alert-heading">Feeds Available</h4>
</div>

<table class="table table-hover" style="">

  <?php foreach ($feeds as $feed){ ?>
    <tr>
    <td><b><?php echo $feed['id']; ?></b></td>
    <td><b><?php echo $feed['name']; ?></b></td>
    <td><b><?php echo $feed['tag']; ?></b></td>

   <td><div class="createsummary btn"
            summaryid="<?php echo $feed['id']; ?>"
            summaryname="<?php echo $feed['name']; ?>"
            summarytag="<?php echo $feed['tag']; ?>"

        >Create</div></td>

      </tr>
  <?php } ?>
</table>
<?php } ?>
<?php } ?>



<script type="application/javascript">var path =   "<?php echo $path; ?>
    ";
    //TODO Dialog to show update is running
    $(".createsummary").click(function() {
    var summaryid = $(this).attr("summaryid");
    var summaryname = $(this).attr("summaryname");
    var summarytag = $(this).attr("summarytag");
    $.ajax({type:'GET',url:path+'summary/create.json',data:'summaryid='+summaryid+'&summaryname='+summaryname+'&summarytag='+summarytag,dataType:'json',success:function(){location.reload();}});
    return false;
    });

    $(".viewsummary").click(function() {
    var result = {};
    var summaryid = $(this).attr("summaryid");
    var summaryname = $(this).attr("summaryname");
    var summarytag = $(this).attr("summarytag");
    $.ajax({type:'GET',url:path+'summary/view.json',data:'summaryid='+summaryid+'&summaryname='+summaryname+'&summarytag='+summarytag,dataType:'json', async: false, success: function(data) {result = data;}});
    return result;
    });

    $(".managesummary").click(function(e) {
    e.preventDefault();
    var summaryid = $(this).attr("summaryid");
    $('.feed_id_row'+summaryid).toggle();
    console.log('Manage Button Clicked');
    });
</script>
