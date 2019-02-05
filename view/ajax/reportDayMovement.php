<?php
$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/bichoensaboado/dao/ReportDAO.php";
include $path . "/bichoensaboado/inc/functions.php";

$reportDao = new ReportDAO();
$reportDayMovementList = $reportDao->reportDayMovement();
$reportSangriaOfDaytList = $reportDao->reportSangriaOfDay();
$reportSangriaOfDaytList->column1Report;

foreach ($reportDayMovementList as $report) {
    $report->column7Report = $reportSangriaOfDaytList->column1Report;
}

if (count($reportDayMovementList) == 0) {
    echo '[]';
} else {
    echo listObject2Json($reportDayMovementList);
}
