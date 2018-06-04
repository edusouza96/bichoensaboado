<?php
  date_default_timezone_set('America/Sao_Paulo');

  $idFieldParam         = $_GET['idField'];
  $ownerParam           = $_GET['owner'];
  $serviceParam         = $_GET['service'];
  $searchParam          = $_GET['search'];
  $priceParam           = $_GET['price'];
  $deliveryPriceParam   = $_GET['deliveryPrice'];
  $totalPriceParam      = $_GET['totalPrice'];
  $dateHourParam        = $_GET['dateHour'];
  
  $path = $_SERVER['DOCUMENT_ROOT']; 
  include_once($path."/bichoensaboado/dao/VetDAO.php");
  include_once($path."/bichoensaboado/class/VetClass.php");
  include_once($path."/bichoensaboado/dao/ServicDAO.php");
  
  $servicDao = new ServicDAO();
  $servic = $servicDao->SearchId($serviceParam);

    $vet = new VetClass();
    $vet->VetClass(
      0, 
      $ownerParam, 
      $serviceParam, 
      $searchParam, 
      $priceParam, 
      $deliveryPriceParam, 
      $totalPriceParam, 
      $dateHourParam
    );
      
    $vetDao = new VetDAO();
    $response = $vetDao->Insert($vet);

  echo $response;
?>

