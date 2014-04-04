<?php
global $path;
 ?>
<div id="myimgdiv">
<img id="loader" src="<?php echo $path; ?>Modules/summary/Views/images/loader.gif" class="loader" />
</div>

<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>Modules/summary/Views/css/main.css">


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
    <td> <a href="<?php echo $path; ?>summary/view?summaryid=<?php echo $myfeedsum['feed_id']; ?>&summary_tag=<?php echo $myfeedsum['summary_tag']; ?>&feed_name=<?php echo $myfeedsum['feed_name']; ?>"  class="btn btn-info">View</a></td>
    <td><div class="managesummary btn btn-info" 
        summaryid="<?php echo $myfeedsum['feed_id']; ?>"
        summaryname="<?php echo $myfeedsum['feed_name']; ?>"
        summarytag="<?php echo $myfeedsum['summary_tag']; ?>"
        >Manage</div></td>   
  </tr>
 <?php 

    foreach ($feedsumlist as $myfeedsumlist){
        $curdate = date("Y-m-d");
        $date1 = new DateTime($curdate);
        $sqldate = $myfeedsumlist['summary_date'];
        $date2 = new DateTime($sqldate);
        $interval = $date1->diff($date2);
        $status = "";
        if ($myfeedsumlist['summary_type'] == 'Daily')
            { 
                if ($interval->d > 14) {
                    $status = "Red";
                }
                else if ($interval->d > 7) {
                    $status = "Orange";
                }
                else if ($interval->d > 1) {
                    $status = "Yellow";
                }
                else $status ="Green";
            }
        else if ($myfeedsumlist['summary_type'] == 'Weekly')
            {   
                if ($interval->d > 28) {
                    $status = "Red";
                }
                else if ($interval->d > 21) {
                    $status = "Orange";
                }
                else if ($interval->d > 14) {
                    $status = "Yellow";
                }
                else $status ="Green";              
            }
        else if ($myfeedsumlist['summary_type'] == 'Monthly')
            {   
                if ($interval->m > 3) {
                    $status = "Red";
                }
                else if ($interval->m > 2) {
                    $status = "Orange";
                }
                else if ($interval->m > 1) {
                    $status = "Yellow";
                }
                else $status ="Green";
            }
        if($myfeedsumlist['feed_id'] == $myfeedsum['feed_id']) {
    
 ?>
  <tr class="feed_id_row<?php echo $myfeedsum['feed_id']; ?>" style="display:none">
    <td><b></b></td>
    <td><b><?php echo $myfeedsumlist['summary_type']; ?></b></td>
    <td><b>Last Updated : <?php echo date("d-m-Y", strtotime($myfeedsumlist['summary_date'])); ?></b></td>
    <td><div style="background-color: <?=getProperColor($status) ?>;"><b>Status :  <?php echo $status; ?></b></td>
     <td><a href="<?php echo $path; ?>summary/update?summaryid=<?php echo $myfeedsum['feed_id']; ?>&summary_date=<?php echo $myfeedsumlist['summary_date']; ?>&summary_type=<?php echo $myfeedsumlist['summary_type']; ?>&summary_name=<?php echo $myfeedsum['feed_name']; ?>" class="updatesummary btn btn-info" style="display:  <?=getUpdateStatus($status) ?>;">
            Update</a></td>
  </tr>
<?php }} ?>
  </tr>
    <tr align="right"  class="feed_id_row<?php echo $myfeedsum['feed_id']; ?>" style="display:none">
    <td><b></b></td>
    <td><b></b></td>
    <td><b></b></td>
    <td><b></b></td>
   <td><div class="deletesummary btn btn-info"
            summaryid="<?php echo $myfeedsum['feed_id']; ?>"
            
        >Delete</div></td>
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
<?php
// Set color of status in Manage View
function getProperColor($status) {
    if ($status == "Red")
        return '#FF0000';
    else if ($status == "Orange")
        return '#FF9900';
    else if ($status == "Yellow")
        return '#FFFF00';
    else
        return '#99FF00';

}
// Show or hide Update button depending on Status color
function getUpdateStatus($status) {
    if ($status == "Green")
        return 'none';
    else
        return 'inline';
}
 ?>


<script type="application/javascript">

    var path = "<?php echo $path; ?>";
    
    $('#loader').hide();
        
    $(".createsummary").click(function(create) {
    $('#loader').show();
    var summaryid = $(this).attr("summaryid");
    var summaryname = $(this).attr("summaryname");
    var summarytag = $(this).attr("summarytag");
    $.ajax({type:'GET',url:path+'summary/createsum.json',data:'summaryid='+summaryid+'&summaryname='+summaryname+'&summarytag='+summarytag,dataType:'json',success:function(a){location.reload();}});
    return false;
    });

    $(".managesummary").click(function(e) {
    e.preventDefault();
    var summaryid = $(this).attr("summaryid");
    $('.feed_id_row'+summaryid).toggle();
    console.log('Manage Button Clicked');
    });
    
    $(".updatesummary").click(function() {
        $('#loader').show();
        console.log('Update Button Clicked');
    });
    
    $(".deletesummary").click(function() {
    $('#loader').show();
    var summaryid = $(this).attr("summaryid");
    $.ajax({type:'GET',url:path+'summary/deletesum.json',data:'summaryid='+summaryid,dataType:'json',success:function(a){location.reload();}});
    return false;
    console.log('Delete Button Clicked');
    });

</script>
