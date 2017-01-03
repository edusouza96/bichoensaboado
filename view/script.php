<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 

    include_once($path."/bichoensaboado/dao/ClientDAO.php");
    include_once($path."/bichoensaboado/class/ClientClass.php");

    $client = new ClientClass();
    $clientDao = new ClientDAO();
    
    $client->owner = 'SOLANGE MATTOS';
    $client->nameAnimal = 'JUNIOR';
    $client->breed = '29';
    $client->addressNumber = 'LOTE 128';
    $client->address ='52' ;
    $client->phone1 = '81323266';
    $client->phone2 = '';
    $client->email = 'SOLAMATTOS@TERRA.COM.BR';

    $x = $clientDao->Insert($client);
    echo $x;
?>
