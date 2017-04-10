<?php
  $id = $_GET['id'];
  $field = $_GET['field'];
  $path = $_SERVER['DOCUMENT_ROOT']; 

if($field == 'name'){
  include_once($path."/bichoensaboado/dao/ClientDAO.php");
  $clientDao = new ClientDAO();
  $clientList = $clientDao->SearchAnimalsSameOwnerByIdOwner($id);

  foreach($clientList as $client){
    $list[] = $client->idClient.'#'.$client->breed->idBreed.'|'.utf8_encode($client->nameAnimal);
  }
}else if($field == 'servic'){
  include_once($path."/bichoensaboado/dao/ServicDAO.php");
  $servicDao = new ServicDAO();
  $servicList = $servicDao->SearchBreed($id);

  foreach($servicList as $servic){
    $list[] = $servic->idServic.'|'.utf8_encode($servic->nameServic);
  }
}else if($field == 'save'){

  $idServic = $_GET['idServic'];
  $idClient = $_GET['idClient'];
  $idBreed = $_GET['idBreed'];
  include_once($path."/bichoensaboado/dao/DiaryDAO.php");
  include_once($path."/bichoensaboado/dao/ServicDAO.php");

  $diaryDao = new DiaryDAO();
  $diaryDao->UpdateCompanion($id,'true');

  $diaryDao = new DiaryDAO();
  $servicDao = new ServicDAO();
  $servicClass = $servicDao->SearchId($idServic);

  $diaryClass = $diaryDao->SearchId($id);
  $diaryClass->servic = $idServic;
  $diaryClass->client = $idClient;
  $diaryClass->deliveryPrice = 0;
  $diaryClass->price = $servicClass->valuation;
  $diaryClass->totalPrice = $servicClass->valuation;
  $diaryClass->package = 0;
  $idDiaryLast = $diaryDao->Insert($diaryClass);

  $diaryDao = new DiaryDAO();
  $diaryDao->UpdateCompanion($idDiaryLast,$id);
  
  $list[] = 'ok';
}
      
echo implode('||', $list);
?>

