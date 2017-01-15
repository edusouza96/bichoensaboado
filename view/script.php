<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 

    // include_once($path."/bichoensaboado/dao/BreedDAO.php");
    // include_once($path."/bichoensaboado/dao/ServicDAO.php");
    // include_once($path."/bichoensaboado/class/ServicClass.php");
    // $breedDao = new BreedDAO();
    // $breedList = $breedDao->SearchAll();
    // $servicDao = new ServicDAO();
    // $servicClass = new ServicClass();
    // foreach($breedList as $breed){
    //     $servicClass->nameServic = "Pacote 15";
    //     $servicClass->breed = $breed->idBreed;
    //     $servicClass->valuation = 100;
    //     $servicClass->package = 1;
    //     $servicDao->Insert($servicClass);
        
    //     $servicClass->nameServic = "Pacote 30";
    //     $servicClass->breed = $breed->idBreed;
    //     $servicClass->valuation = 200;
    //     $servicClass->package = 2;
    //     $servicDao->Insert($servicClass);

    // }

    // include_once($path."/bichoensaboado/dao/ClientDAO.php");
    // include_once($path."/bichoensaboado/class/ClientClass.php");

    // $client = new ClientClass();
    // $clientDao = new ClientDAO();
    
    // $client->owner = 'SOLANGE MATTOS';
    // $client->nameAnimal = 'JUNIOR';
    // $client->breed = '29';
    // $client->addressNumber = 'LOTE 128';
    // $client->address ='52' ;
    // $client->phone1 = '81323266';
    // $client->phone2 = '';
    // $client->email = 'SOLAMATTOS@TERRA.COM.BR';

    // $x = $clientDao->Insert($client);
    // echo $x;
    
    // include_once($path."/bichoensaboado/dao/DiaryDAO.php");
    // include_once($path."/bichoensaboado/class/DiaryClass.php");
    // $diaryDao = new DiaryDAO();
    // $clientDao = new ClientDAO();
    // $clientList = $clientDao->SearchAll(); 
    // echo '<pre>';
    // print_r($clientList);
    // echo '</pre>';

    
// $row = 1;
// if (($handle = fopen("dados.csv", "r")) !== FALSE) {
//     while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
//         // $num = count($data);
//         // echo "<p> $num campos na linha $row: <br /></p>\n";
//         $row++;
//         // for ($c=0; $c < $num; $c++) {
//         //     echo $data[$c] . "<br />\n";
//             $client->owner = $data[0];
//             $client->nameAnimal = $data[1];
//             $client->breed = $data[2];
//             $client->addressNumber = $data[3];
//             $client->address =$data[4] ;
//             $client->phone1 = $data[5];
//             $client->phone2 = $data[6];
//             $client->email = $data[7];
            
//             // echo '<pre>';
//             // print_r($client);
//             // echo '</pre>';
//             $x = $clientDao->Insert($client);
//             echo $x;
//         // }
//     }
//     fclose($handle);
// }
    
?>
