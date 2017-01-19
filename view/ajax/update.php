<?php
  date_default_timezone_set('America/Sao_Paulo');
  $dateHour = $_GET['dateHour'];
  $idField = $_GET['idField'];
  $search = $_GET['search'];
  $deliveryPrice = $_GET['deliveryPrice'];
  
  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/PackageDAO.php");
  include_once($path."/bichoensaboado/dao/DiaryDAO.php");
  include_once($path."/bichoensaboado/class/DiaryClass.php");

  $diaryDao = new DiaryDAO();
  $diary = $diaryDao->SearchId($idField);
  $dateHourOld = $diary->dateHour;
  $diary->dateHour = $dateHour;
  $diary->search = $search;
  $diary->deliveryPrice = $deliveryPrice;
  $price = $diary->price;
  $diary->totalPrice = $price + $deliveryPrice;

  $response = $diaryDao->Update($diary);
  if($diary->package->idPackage > 0){
    $packageDao = new PackageDAO();
    $package = $packageDao->SearchId($diary->package->idPackage);

    $weekDescremento = 0;
    for($iPack = 1; $iPack<5; $iPack++){
        $datePack = 'date'.$iPack;
        $weekPack = 'week'.$iPack;
        if($dateHourOld == $package->${'datePack'}){
            $weekDescremento = 1;
            $package->${'datePack'} = $dateHour;
            $package->${'weekPack'} = 5;
        }
        $package->${'weekPack'} -= $weekDescremento;
        
    }
    
    $packageDao->Update($package);
  }
 
  echo $response;    
?>

