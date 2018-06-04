<?php
  date_default_timezone_set('America/Sao_Paulo');
  $dateHour = $_GET['dateHour'];
  $idField = $_GET['idField'];
  $search = $_GET['search'];
  $deliveryPrice = $_GET['deliveryPrice'];
  $idServic = $_GET['servic'];

  $idServic = explode('|',$idServic);
  $idField = explode('|',$idField);
  

  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/VetDAO.php");
  include_once($path."/bichoensaboado/dao/ServicDAO.php");
  include_once($path."/bichoensaboado/class/VetClass.php");
  for($i=0; $i<count($idField); $i++){
    $servicDao = new ServicDAO();
    $servic = $servicDao->SearchId($idServic[$i]);
    $vetDao = new VetDAO();
    $vet = $vetDao->SearchId($idField[$i]);
    $dateHourOld = $vet->dateHour;
    $vet->dateHour = $dateHour;
    $vet->servic = $servic;
    if($i > 0){
      $deliveryPrice = 0;
    }

    $vet->deliveryPrice = $deliveryPrice;
    $price = $servic->valuation;
    $vet->price = $price;
    $vet->totalPrice = $price + $deliveryPrice;
    $vet->search = $search;

    $response = $vetDao->Update($vet);
  }

  echo $response;    
?>

