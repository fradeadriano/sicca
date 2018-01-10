<?php
include ("../../../../librerias/jpgraph/src/jpgraph.php");
include ("../../../../librerias/jpgraph/src/jpgraph_gantt.php");

$graph = new GanttGraph(0,0,"auto");
$graph->SetShadow();

// Add title and subtitle
$graph->title->Set("A nice main title");
$graph->title->SetFont(FF_ARIAL,FS_BOLD,12);
$graph->subtitle->Set("(Draft version)");

// Show day, week and month scale
$graph->ShowHeaders(GANTT_HDAY | GANTT_HWEEK | GANTT_HMONTH);

// Instead of week number show the date for the first day in the week
// on the week scale
$graph->scale->week->SetStyle(WEEKSTYLE_FIRSTDAY);

// Make the week scale font smaller than the default
$graph->scale->week->SetFont(FF_FONT0);

// Use the short name of the month together with a 2 digit year
// on the month scale
$graph->scale->month->SetStyle(MONTHSTYLE_SHORTNAMEYEAR4);
$graph->scale->month->SetFontColor("white");
$graph->scale->month->SetBackgroundColor("blue");

// Format the bar for the first activity
// ($row,$title,$startdate,$enddate)
$activity = new GanttBar(0,"Project","2001-12-21","2002-02-20");
$activity1 = new GanttBar(1,"Project","2001-12-21","2002-02-20");
$activity2 = new GanttBar(2,"Project","2001-12-21","2002-02-20");
$activity3 = new GanttBar(3,"Project","2001-12-21","2002-02-20");
$activity4 = new GanttBar(4,"Project","2001-12-21","2002-02-20");
$activity5 = new GanttBar(5,"Project","2001-12-21","2002-02-20");
$activity6 = new GanttBar(6,"Project","2001-12-21","2002-02-20");


// Yellow diagonal line pattern on a red background
$activity->SetPattern(BAND_RDIAG,"yellow");
$activity->SetFillColor("red");

// Finally add the bar to the graph
$graph->Add($activity);
$graph->Add($activity1);
$graph->Add($activity2);
$graph->Add($activity3);
$graph->Add($activity4);
$graph->Add($activity5);
$graph->Add($activity6);

// Create a miletone
$milestone = new MileStone(10,"Milestone","2002-01-15","2002-01-15");
$milestone->title->SetColor("black");
$milestone->title->SetFont(FF_FONT1,FS_BOLD);
$graph->Add($milestone);

// ... and display it
$graph->Stroke();
?>