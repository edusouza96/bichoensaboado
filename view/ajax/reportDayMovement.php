<?php
$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/bichoensaboado/dao/ReportDAO.php";
include $path . "/bichoensaboado/inc/functions.php";

$reportDao = new ReportDAO();
$reportDayMovementList = $reportDao->reportDayMovement();

if (count($reportDayMovementList) == 0) {
    echo '{}';
} else {
    echo listObject2Json($reportDayMovementList);
}
