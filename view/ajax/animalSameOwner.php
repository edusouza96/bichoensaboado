<?php
  $id = $_GET['id'];
  $field = $_GET['field'];
  $path = $_SERVER['DOCUMENT_ROOT']; 

if($field == 'name'){
  include_once($path."/bichoensaboado/dao/ClientDAO.php");
  $clientDao = new ClientDAO();
  $clientList = $clientDao->SearchAnimalsSameOwnerByIdOwner($id);

  foreach($clientList as $client){
    $list[] = $client->breed->idBreed.'|'.utf8_encode($client->nameAnimal);
  }
}else if($field == 'servic'){
  include_once($path."/bichoensaboado/dao/ServicDAO.php");
  $servicDao = new ServicDAO();
  $servicList = $servicDao->SearchBreed($id);

  foreach($servicList as $servic){
    $list[] = $servic->idServic.'|'.utf8_encode($servic->nameServic);
  }
}
      
echo implode('||', $list);

?>

