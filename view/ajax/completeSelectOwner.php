<?php
  $nameAnimal = $_GET['nameAnimal'];
  $idField = $_GET['idField'];
  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/ClientDAO.php");
  
  $clientDao = new ClientDAO();
  $clientList = $clientDao->SearchOwner(utf8_decode($nameAnimal));

  $list = array('idField' => $idField);
  foreach($clientList as $client){
    $list[] = $client->idClient."|".$client->owner;
  }    
  echo implode(',' , $list);

?>

