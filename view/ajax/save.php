<?php
  date_default_timezone_set('America/Sao_Paulo');
  // $paramSave = $_GET['paramSave'];
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
  
  // $paramDiary = explode('|', $paramSave);
  // $auxParamDiary = $paramDiary;

  $servicDao = new ServicDAO();
  $servic = $servicDao->SearchId($serviceParam);
/**
 * TODO : Re-Criar a logica para salvar os pacotes
 */
  if($servic->package == 2){
    for($i=0; $i<4; $i++){
      $date = "date".($i+1);
      $week = "week".($i+1);
      $package->${'date'} = $dateHourParam;
      $package->${'week'} = $i+1;

      $dateHourParam = new DateTime($dateHourParam);
      $dateHourParam->add(new DateInterval('P7D'));
      $dateHourParam = $dateHourParam->format('Y-m-d H:i');
    }
    $idPackage = $packageDao->Insert($package);

    for($i=0; $i<4; $i++){
      $diary = new DiaryClass();
      $diary->DiaryClass(0
                        , $ownerParam
                        , $serviceParam
                        , $searchParam
                        , $priceParam
                        , ($deliveryPriceParam * 4)
                        , ($totalPriceParam + ($deliveryPriceParam * 3))
                        , $dateHourParam
                        , $idPackage
                        );
      
      $dateHourParam = new DateTime($dateHourParam);
      $dateHourParam->add(new DateInterval('P7D'));
      $dateHourParam=$dateHourParam->format('Y-m-d H:i');
      $priceParam = 0;
      $deliveryPriceParam = 0;
      $totalPriceParam = 0;

      $diaryDao = new DiaryDAO();
      $response = $diaryDao->Insert($diary);
    }     
  }else if($servic->package == 1){
    for($i=0; $i<2; $i++){
      $date = "date".($i+1);
      $week = "week".($i+1);
      $package->${'date'} = $dateHourParam;
      $package->${'week'} = $i+1;

      $date = "date".($i+3);
      $week = "week".($i+3);
      $package->${'date'} = 0;
      $package->${'week'} = 0;

      $dateHourParam = new DateTime($dateHourParam);
      $dateHourParam->add(new DateInterval('P7D'));
      $dateHourParam=$dateHourParam->format('Y-m-d H:i');
    }
    $idPackage = $packageDao->Insert($package);

    for($i=0; $i<2; $i++){
      $diary = new DiaryClass();
      $diary->DiaryClass(0
                        , $ownerParam
                        , $serviceParam
                        , $searchParam
                        , $priceParam
                        , ($deliveryPriceParam * 2)
                        , ($totalPriceParam + $deliveryPriceParam)
                        , $dateHourParam
                        , $idPackage
                        );
      
      $dateHourParam = new DateTime($dateHourParam);
      $dateHourParam->add(new DateInterval('P14D'));
      $dateHourParam=$dateHourParam->format('Y-m-d H:i');
      $priceParam = 0;
      $deliveryPriceParam = 0;
      $totalPriceParam = 0;

      $diaryDao = new DiaryDAO();
      $response = $diaryDao->Insert($diary);
    }
  }else if($servic->package == 0){
      $diary = new DiaryClass();
      $diary->DiaryClass(0, $ownerParam, $serviceParam, $searchParam, $priceParam, $deliveryPriceParam, $totalPriceParam, $dateHourParam, 0);
      
      $diaryDao = new DiaryDAO();
      $response = $diaryDao->Insert($diary);
  }

  echo $response;    
?>

