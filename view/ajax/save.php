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
  $dateHourPackageParam = $_GET['dateHourPackage'];
  
  $path = $_SERVER['DOCUMENT_ROOT']; 
  include_once($path."/bichoensaboado/dao/DiaryDAO.php");
  include_once($path."/bichoensaboado/class/DiaryClass.php");
  include_once($path."/bichoensaboado/dao/ServicDAO.php");
  include_once($path."/bichoensaboado/dao/PackageDAO.php");
  include_once($path."/bichoensaboado/class/PackageClass.php");

  $package = new PackageClass();
  $packageDao = new PackageDAO();
  
  $servicDao = new ServicDAO();
  $servic = $servicDao->SearchId($serviceParam);

  if($servic->package > 0){
    foreach ($dateHourPackageParam as $key => $dateHourItem) {
      $dateHourItem = $dateHourItem['date'] .' ' . $dateHourItem['hour'];

      $date = "date".($key+1);
      $week = "week".($key+1);
      $package->${'date'} = $dateHourItem;
      $package->${'week'} = $key+1;

      $date = "date".($key+3);
      $week = "week".($key+3);
      $package->${'date'} = 0;
      $package->${'week'} = 0;
    }

    $idPackage = $packageDao->Insert($package);

    foreach ($dateHourPackageParam as $key => $dateHourItem) {
      $dateHourItem = $dateHourItem['date'] .' ' . $dateHourItem['hour'];
      $diary = new DiaryClass();
      $diary->DiaryClass(0
                        , $ownerParam
                        , $serviceParam
                        , $searchParam
                        , $priceParam
                        , ($deliveryPriceParam * 4)
                        , ($totalPriceParam + ($deliveryPriceParam * 3))
                        , $dateHourItem
                        , $idPackage
                        );
      
      $priceParam = 0;
      $deliveryPriceParam = 0;
      $totalPriceParam = 0;

      $diaryDao = new DiaryDAO();
      $response = $diaryDao->Insert($diary);
    }   
  }
  
  else if($servic->package == 0){
    $diary = new DiaryClass();
    $diary->DiaryClass(
      0, 
      $ownerParam, 
      $serviceParam, 
      $searchParam, 
      $priceParam, 
      $deliveryPriceParam, 
      $totalPriceParam, 
      $dateHourParam, 
      0
    );
      
    $diaryDao = new DiaryDAO();
    $response = $diaryDao->Insert($diary);
  }

  echo $response;
?>

