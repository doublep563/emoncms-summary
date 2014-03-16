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
    <td> <a href="<?php echo $path; ?>summary/manage?summaryid=<?php echo $myfeedsum['feed_id']; ?>"  class="btn btn-info"><?php echo _('Manage'); ?></a></td>
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



<script type="application/javascript">var path =  "<?php echo $path; ?>
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

</script>
