<?php
$idService = $_GET['idService'];
$idField = $_GET['idField'];
$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/bichoensaboado/dao/ServicDAO.php";

$servicDao = new ServicDAO();
$servic = $servicDao->SearchId($idService);

$list = array('idField' => $idField,
    'valuation' => $servic->valuation,
    'package' => $servic->package,
);

echo json_encode($list);
