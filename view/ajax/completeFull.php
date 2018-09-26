<?php
header('Content-Type: text/html; charset=utf-8');
$idClient = $_GET['idClient'];
$idField = $_GET['idField'];
$path = $_SERVER['DOCUMENT_ROOT'];

include_once $path . "/bichoensaboado/dao/ClientDAO.php";
include_once $path . "/bichoensaboado/dao/ServicDAO.php";

$clientDao = new ClientDAO();
$client = $clientDao->SearchId($idClient);

$servicDao = new ServicDAO();
$servicPetList = $servicDao->SearchBreed($client->breed->idBreed);
$servicVetList = $servicDao->SearchVet();

$addressDao = new AddressDAO();
$address = $addressDao->SearchId($client->address->idAddress);

$list = array('idField' => $idField,
    'breed' => utf8_encode($client->breed->nameBreed),
    'addressComplement' => is_null($client->addressComplement) ? "" : utf8_encode($client->addressComplement),
    'addressNumber' => utf8_encode($client->addressNumber),
    'street' => utf8_encode($client->address->street),
    'district' => utf8_encode($client->address->district),
    'phone1' => $client->phone1,
    'phone2' => $client->phone2,
    'deliveryPrice' => $address->valuation,
);
foreach ($servicPetList as $servic) {
    $list['servicPet'][$servic->idServic] = ($servic->nameServic);
}
foreach ($servicVetList as $servic) {
    $list['servicVet'][$servic->idServic] = ($servic->nameServic);
}
echo json_encode($list);
