<?php
$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/bichoensaboado/dao/ReportDAO.php";
include $path . "/bichoensaboado/inc/functions.php";

$reportDao = new ReportDAO();
$reportDayMovementList = $reportDao->reportDayMovement();
$reportSangriaOfDaytList = $reportDao->reportSangriaOfDay();
$reportSangriaOfDaytList->column1Report;
$reportFinancialOutOfDaytList = $reportDao->reportFinancialOut();

foreach ($reportDayMovementList as $report) {
    $report->column7Report = $reportSangriaOfDaytList->column1Report;

    $report->column8Report = $reportFinancialOutOfDaytList->column8Report;
    $report->column9Report = $reportFinancialOutOfDaytList->column9Report;
    $report->column10Report = $reportFinancialOutOfDaytList->column10Report;
    $report->idReport = $reportFinancialOutOfDaytList->idReport;
}

if (count($reportDayMovementList) == 0) {
    echo '[]';
} else {
    echo listObject2Json($reportDayMovementList);
}
