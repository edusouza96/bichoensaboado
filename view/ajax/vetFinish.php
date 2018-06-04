<?php
  date_default_timezone_set('America/Sao_Paulo');
  $idVet = $_GET['idVet'];
  $status = $_GET['status'];
  $path = $_SERVER['DOCUMENT_ROOT']; 
  $dateHour = '';
  $servicePay = 0;

  include_once($path."/bichoensaboado/dao/VetDAO.php");
  include_once($path."/bichoensaboado/class/VetClass.php");
  include_once($path."/bichoensaboado/dao/SalesDAO.php");
  
  $vetDao = new VetDAO();
  $response = $vetDao->UpdateStatus($idVet,$status);
  if($status == -1){
    $response = $vetDao->Delete($idVet);
  }
  if($status == 2){
    $salesDao = new SalesDAO();
    $salesDao->addWhere(' vet_idVet = '.$idVet);
    $salesList = $salesDao->searchAll();
    if(count($salesList) > 0){
      $servicePay = 1;
    }
  }
  if($status == 1){
    $vet = $vetDao->SearchId($idVet);
    $dataHourDB = new DateTime($vet->dateHour);
    $date = $dataHourDB->format('Y-m-d');
    $hour = $dataHourDB->format('H:i');
    $dateHour = "|".$hour."|".$date."|";

  }
  echo $response."|".$idVet."|".$status."".$dateHour."|".$servicePay;    
?>

