<?php
$idRebate = $_GET['idRebate'];
$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/bichoensaboado/dao/RebateDAO.php";

$rebateDao = new RebateDAO();
$rebate = $rebateDao->searchId($idRebate);

echo $rebate->valueRebate;
