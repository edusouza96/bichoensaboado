<?php
  $idClient = $_GET['idClient'];
  $idField = $_GET['idField'];
  $path = $_SERVER['DOCUMENT_ROOT']; 
  include_once($path."/bichoensaboado/dao/ClientDAO.php");
  $clientDao = new ClientDAO();
  $list = $clientDao->SearchId($idClient);
  $list = array('idField' => $idField ,'breed' => $list->breed->nameBreed, 'addressComplement' => $list->addressComplement, 'addressNumber' => $list->addressNumber, 'street' => $list->address->street, 'district' => $list->address->district, 'phone1' => $list->phone1,'phone2' => $list->phone2);
 	echo implode(',' , $list);

?>

