<?php
global $path;
?>

<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <meta name="author" content="Script Tutorials" />
        <title>Emoncms Feed Summary</title>

        <script src="<?php echo $path; ?>Lib/summary/jquery-1.9.0.min.js"></script>
        <script src="<?php echo $path; ?>Modules/summary/Highcharts/js/highcharts.js"></script>
        <script src="<?php echo $path; ?>Modules/summary/Views/js/dark-green.js"></script>

        <?php

        //echo json_encode($feedsumdata);

        //$obj = json_decode($feedsumdata,true);
        //print_r($obj);
        //$name = $feedsumdata['name'];
        $averages = $feedsumdata[0];
        $minimums = $feedsumdata[1];
        $maximums = $feedsumdata[2];
        //print "<pre>";
        //print_r($averages);
        //print "<pre>";
        //$JSaverages['averages'] = json_encode($averages,JSON_NUMERIC_CHECK);
        //echo $name ;
        //print_r($averages);
        //$averages = $obj->averages;
        //print_r($averages);
        ?>
    </head>
    <body>
        <header>
            <h2>Emoncms Feed Summary</h2>
        </header>

        <!-- Various actions -->
        <div class="actions">
            <button class="switcher" id="Daily">
                Daily
            </button>
            <button class="switcher" id="Weekly">
                Weekly
            </button>
            <button class="switcher" id="Monthly">
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

console.log('Start HC Java Script');
// prepare an empty Highcharts object
chart = new Highcharts.Chart({
chart: {
renderTo: 'container',
showAxes: true,
height: 700
},
title: {
text:  'Daily Summary'
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
lineWidth: 4,
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

// re-set categories for X axe
//chart.xAxis[0].setCategories(aData.dates);

chart.yAxis[0].axisTitle.attr({
//text: aData.name
text: 'Temperature'
});

// gather data (averages) and prepare a new Series array

var seriesAverages = {
name: 'Average',
//data: aData.averages,
data: <?php echo json_encode($averages, JSON_NUMERIC_CHECK); ?>,
type: 'column',
color: '#7798BF'

}

var seriesMinimums = {
name: 'Minimum',
data: <?php echo json_encode($minimums, JSON_NUMERIC_CHECK); ?>,
type: 'spline',
color: '#DDDF0D'
}

var seriesMaximums = {
name: 'Maximum',
data: <?php echo json_encode($maximums, JSON_NUMERIC_CHECK); ?>,
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

$('.switcher').click(function () {
var id = $(this).attr('id');

console.log('Start HC Java Script - Switcher');
//var chart = chart['container'];
// display Loading message
chart.showLoading('Getting stat data ....');

// get stat data (json)

// remove all existing series
while (chart.series.length) {
chart.series[0].remove();
}

// re-set categories for X axe
//chart.xAxis[0].setCategories(aData.dates);

chart.yAxis[0].axisTitle.attr({
//text: aData.name

});

// gather data (averages) and prepare a new Series array

var seriesAverages = {
name: 'Average',
data: <?php echo json_encode($averages, JSON_NUMERIC_CHECK); ?>,
type: 'column',
color: '#7798BF'
}

var seriesMinimums = {
name: 'Minimum',
data: <?php echo json_encode($minimums, JSON_NUMERIC_CHECK); ?>,
type: 'spline',
color: '#DDDF0D'
}

var seriesMaximums = {
name: 'Minimum',
data: <?php echo json_encode($maximums, JSON_NUMERIC_CHECK); ?>
    , type: 'spline',
    color: '#DF5353'
    }

    // hide Loading, add both series and redraw our chart
    chart.hideLoading();
    chart.addSeries(seriesAverages, false);
    chart.addSeries(seriesMinimums, false);
    chart.addSeries(seriesMaximums, false);

    chart.redraw();

    });

</script>