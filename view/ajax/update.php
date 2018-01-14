<?php
  date_default_timezone_set('America/Sao_Paulo');
  $dateHour = $_GET['dateHour'];
  $idField = $_GET['idField'];
  $search = $_GET['search'];
  $deliveryPrice = $_GET['deliveryPrice'];
  $idServic = $_GET['servic'];

  $idServic = explode('|',$idServic);
  $idField = explode('|',$idField);
  

  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/PackageDAO.php");
  include_once($path."/bichoensaboado/dao/DiaryDAO.php");
  include_once($path."/bichoensaboado/dao/ServicDAO.php");
  include_once($path."/bichoensaboado/class/DiaryClass.php");
  for($i=0; $i<count($idField); $i++){
    $servicDao = new ServicDAO();
    $servic = $servicDao->SearchId($idServic[$i]);
    $diaryDao = new DiaryDAO();
    $diary = $diaryDao->SearchId($idField[$i]);
    $dateHourOld = $diary->dateHour;
    $diary->dateHour = $dateHour;
    $diary->servic = $servic;
    if($i > 0){
      $deliveryPrice = 0;
    }

    /**
    * Se n�o for um pacote � atualizado o valor do servi�o e o frete normalmente
    * Caso contrario � atualizado apenas o frete, caso tenha modificado esta op��o
    */
    if($diary->package->idPackage == 0){
      $diary->deliveryPrice = $deliveryPrice;
      $price = $servic->valuation;
      $diary->price = $price;
      $diary->totalPrice = $price + $deliveryPrice;
    }else{
      if($diary->search != $search){
        $diary->deliveryPrice = $deliveryPrice;
        $diary->totalPrice = $deliveryPrice;
      }
    }
    $diary->search = $search;
    

    $response = $diaryDao->Update($diary);

    /**
    * Em caso do servi�o ser pacote, � feita a verifica��o de qual semana ser� editada,
    * a seguir � colocado num array todos os dias diferente de null para ser colocado em ordem,
    * para que seja atualizado corretamente de acordo com a semana
    */
    $datesOfPackage = array();
    if($diary->package->idPackage > 0){
      $packageDao = new PackageDAO();
      $package = $packageDao->SearchId($diary->package->idPackage);

      for($iPack = 1; $iPack<5; $iPack++){
        $datePack = 'date'.$iPack;
        if($dateHourOld == $package->${'datePack'}){
            $package->${'datePack'} = $dateHour;
        }

        if($package->${'datePack'} != '0000-00-00 00:00:00'){
          $datesOfPackage[] = $package->${'datePack'};
        }

      }
      
      array_multisort($datesOfPackage);

      foreach($datesOfPackage as $key => $valueDate){
        $datePack = 'date'.($key+1);
        $weekPack = 'week'.($key+1);

        $package->${'datePack'} = $valueDate;
        $package->${'weekPack'} = $key+1;

      }
      
      $packageDao->Update($package);
    }
  }

  echo $response;    
?>

