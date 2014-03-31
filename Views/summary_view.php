<?php
global $path;
?>

<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <meta name="author" content="Script Tutorials" />
        <title>Emoncms Feed Summary</title>
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>Modules/summary/Views/css/main.css">
        <script src="<?php echo $path; ?>Lib/summary/jquery-1.9.0.min.js"></script>
        <script src="<?php echo $path; ?>Modules/summary/Highcharts/js/highcharts.js"></script>
        <script src="<?php echo $path; ?>Modules/summary/Views/js/dark-green.js"></script>

        <?php
        // Spilt out the results of the SQL queries in Daily, Weekly and Monthly arrays
        // Daily
        $daverages = $feedsumdata[0];
        $dminimums = $feedsumdata[1];
        $dmaximums = $feedsumdata[2];
        // Weekly
        $waverages = $feedsumdata[3];
        $wminimums = $feedsumdata[4];
        $wmaximums = $feedsumdata[5];
        // Monthly
        $maverages = $feedsumdata[6];
        $mminimums = $feedsumdata[7];
        $mmaximums = $feedsumdata[8];
        // Title and Axis
        $summary_tag = $feedsumdata[9];
        $feed_name = $feedsumdata[10];
        ?>
    </head>
    <body>
        <div class="alert alert-block">
            <h4 class="alert-heading">Emoncms Feed Summary</h4>
        </div>

        <!-- Various actions -->
        <div class="wrapper">
            <button class="switcher  btn-info" id="Daily">
                Daily
            </button>
            <button class="switcher  btn-info" id="Weekly">
                Weekly
            </button>
            <button class="switcher  btn-info" id="Monthly">
                Monthly
            </button>
        </div>

        <!-- Chart container object -->
        <div id="container" class="chart"></div>
    </body>
</html>

<script type="application/javascript">
        // on document ready
    var chart;
    $(document).ready(function() {

        var averages = <?php echo json_encode($daverages, JSON_NUMERIC_CHECK); ?>;
        var minimums = <?php echo json_encode($dminimums, JSON_NUMERIC_CHECK); ?>;
        var maximums = <?php echo json_encode($dmaximums, JSON_NUMERIC_CHECK); ?>;
        var summary_tag = '<?php echo $summary_tag?>';
        var feed_name = '<?php echo $feed_name?>';
        var cTitle = 'Daily Summary - ' + summary_tag ;
        var yTitle = feed_name;

        //console.log('Start HC Java Script');
        // prepare an empty Highcharts object
        chart = new Highcharts.Chart({
        chart: {
            renderTo: 'container',
            showAxes: true
                },
        title: {
            text:  cTitle
            },
        tooltip: {
        formatter: function() {
            return '<b>'+ this.series.name +'</b><br/>'+
            Highcharts.dateFormat('%d %b %Y', this.x) +': '+ this.y;
            }
        },
        xAxis: {
            type: 'datetime',
                dateTimeLabelFormats: {
                day: '%d %b %Y'
        },
        labels: {
            staggerLines: 1
            },
        title: {
            text: 'Date'
             }
        },
        yAxis: {
            title: {
            text: 'Amount'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
            },
        plotOptions: {
             spline: {
            states: {
            hover: {
            lineWidth: 5
            }
        },
        marker: {
            enabled: false
            }
            }
        },

        });
        // Daily is the default

        // remove all existing series
        while (chart.series.length) {
        chart.series[0].remove();
        }

        chart.yAxis[0].axisTitle.attr({
        text: yTitle
        });

        // gather data (averages) and prepare a new Series array

        var seriesAverages = {
        name: 'Average',
        data: averages,
        type: 'column',
        color: '#7798BF'

        }

        var seriesMinimums = {
        name: 'Minimum',
        data: minimums,
        type: 'spline',
        color: '#DDDF0D'
        }

        var seriesMaximums = {
        name: 'Maximum',
        data: maximums,
        type: 'spline',
        color: '#DF5353'
        }
        // hide Loading, add both series and redraw our chart
        chart.hideLoading();
        chart.addSeries(seriesAverages, false);
        chart.addSeries(seriesMinimums, false);
        chart.addSeries(seriesMaximums, false);

        chart.redraw();

        });

        // The Switcher
        $('.switcher').click(function () {
        var id = $(this).attr('id');

        var summary_tag = '<?php echo $summary_tag?>';

        if (id == 'Daily') {
        var averages = <?php echo json_encode($daverages, JSON_NUMERIC_CHECK); ?>;
        var minimums = <?php echo json_encode($dminimums, JSON_NUMERIC_CHECK); ?>;
        var maximums = <?php echo json_encode($dmaximums, JSON_NUMERIC_CHECK); ?>;
        var cTitle = 'Daily Summary - ' + summary_tag ;
    }

    else if (id == 'Weekly') {
    var averages =  <?php echo json_encode($waverages, JSON_NUMERIC_CHECK); ?>;
        var minimums = <?php echo json_encode($wminimums, JSON_NUMERIC_CHECK); ?>;
        var maximums = <?php echo json_encode($wmaximums, JSON_NUMERIC_CHECK); ?>;
        var cTitle = 'Weekly Summary - ' + summary_tag ;
    }

    else if (id == 'Monthly') {
        var averages =  <?php echo json_encode($maverages, JSON_NUMERIC_CHECK); ?>;
        var minimums = <?php echo json_encode($mminimums, JSON_NUMERIC_CHECK); ?>;
        var maximums = <?php echo json_encode($mmaximums, JSON_NUMERIC_CHECK); ?>;
        var cTitle = 'Monthly Summary - ' + summary_tag;
        }

        // console.log('Start HC Java Script - Switcher' + id);

        // display Loading message
        chart.showLoading('Getting stat data ....');

        chart.setTitle({
            text : cTitle
        });

        // remove all existing series
        while (chart.series.length) {
            chart.series[0].remove();
        }

        chart.yAxis[0].axisTitle.attr({
            // text: aData.name

        });
        chart.xAxis[0].update({
            dateTimeLabelFormats : {
                day : '%d %b %Y'
            }
        })

        // gather data (averages) and prepare a new Series array

        var seriesAverages = {
            name : 'Average',
            data : averages,
            type : 'column',
            color : '#7798BF'
        }

        var seriesMinimums = {
            name : 'Minimum',
            data : minimums,
            type : 'spline',
            color : '#DDDF0D'
        }

        var seriesMaximums = {
            name : 'Minimum',
            data : maximums,
            type : 'spline',
            color : '#DF5353'
        }

        // hide Loading, add both series and redraw our chart
        chart.hideLoading();
        chart.addSeries(seriesAverages, false);
        chart.addSeries(seriesMinimums, false);
        chart.addSeries(seriesMaximums, false);

        chart.redraw();

        });
</script>