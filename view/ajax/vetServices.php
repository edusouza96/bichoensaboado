<?php
  date_default_timezone_set('America/Sao_Paulo');
  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/ServicDAO.php");
  include_once($path."/bichoensaboado/class/ServicClass.php");
  
  $servicDao = new ServicDAO();
  $servicesList = $servicDao->SearchVet();

  $option = "<option value>-- Selecione --</option>";
  foreach($servicesList as $service){
    $option .= "<option value='".$service->idServic."'>".utf8_encode($service->nameServic)."</option>";
  }   
  
  echo $option;
?>

