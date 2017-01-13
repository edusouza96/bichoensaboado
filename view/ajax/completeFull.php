<?php
  $idClient = $_GET['idClient'];
  $idField = $_GET['idField'];
  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/ClientDAO.php");
  include_once($path."/bichoensaboado/dao/ServicDAO.php");
  
  $clientDao = new ClientDAO();
  $client = $clientDao->SearchId($idClient);
 	
   $servicDao = new ServicDAO();
   $servicList = $servicDao->SearchBreed($client->breed->idBreed);

   $addressDao = new AddressDAO();
   $address = $addressDao->SearchId($client->address->idAddress);

   $list = array('idField' => $idField ,
                'breed' => $client->breed->nameBreed, 
                'addressComplement' => $client->addressComplement, 
                'addressNumber' => $client->addressNumber, 
                'street' => $client->address->street, 
                'district' => $client->address->district, 
                'phone1' => $client->phone1,
                'phone2' => $client->phone2,
                'deliveryPrice' => $address->valuation
                );
    foreach ($servicList as $servic) {
      $list[] = $servic->idServic.'|'.$servic->nameServic;
    }
   echo implode('||' , $list);

?>

