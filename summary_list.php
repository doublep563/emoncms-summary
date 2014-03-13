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

<?php } if ($feedsum > 0)  { ?>
<div class="alert alert-block">
<h4 class="alert-heading">Feeds with Summaries</h4>
</div>

<table class="table table-hover" style="">

  <?php foreach ($feedsum as $myfeedsum){ ?>
    <tr>
    <td><b><?php echo $myfeedsum['feed_id']; ?></b></td>
    <td><b><?php echo $myfeedsum['feed_name']; ?></b></td>
    <td><b><?php echo $myfeedsum['summary_tag']; ?></b></td>
    
    <td><div class="viewsummary btn" 
            summaryid="<?php echo $myfeedsum['feed_id']; ?>"
            summaryname="<?php echo $myfeedsum['feed_name']; ?>"
            summarytag="<?php echo $myfeedsum['summary_tag']; ?>"
            
            >View</div></td>
      <td>
    <br>
    <a href="<?php echo $path; ?>summary/view" class="btn btn-info"><?php echo _('Update & check'); ?></a>
  </td>

   <td><div class="managesummary btn"
            summaryid="<?php echo $myfeedsum['feed_id']; ?>"
            summaryname="<?php echo $myfeedsum['feed_name']; ?>"
            summarytag="<?php echo $myfeedsum['summary_tag']; ?>"

        >Manage</div></td>

    

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



<script type="application/javascript">var path =    "<?php echo $path; ?>
    ";

    $(".createsummary").click(function() {
    var summaryid = $(this).attr("summaryid");
    var summaryname = $(this).attr("summaryname");
    var summarytag = $(this).attr("summarytag");
    $.ajax({type:'GET',url:path+'summary/create.json',data:'summaryid='+summaryid+'&summaryname='+summaryname+'&summarytag='+summarytag,dataType:'json',success:function(){location.reload();}});
    return false;
    });

</script>
