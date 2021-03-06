<?php
$id = $_GET['id'];
$field = $_GET['field'];
$path = $_SERVER['DOCUMENT_ROOT'];

if ($field == 'name') {
    include_once $path . "/bichoensaboado/dao/ClientDAO.php";
    $clientDao = new ClientDAO();
    $clientList = $clientDao->SearchAnimalsSameOwnerByIdOwner($id);

    foreach ($clientList as $client) {
        $list['animals'][$client->idClient . '#' . $client->breed->idBreed] = utf8_encode($client->nameAnimal);
    }
    
    echo json_encode($list);

} else if ($field == 'servic') {
    include_once $path . "/bichoensaboado/dao/ServicDAO.php";
    $servicDao = new ServicDAO();
    $servicPetList = $servicDao->SearchBreed($id);
    $servicVetList = $servicDao->SearchVet();

    foreach ($servicPetList as $servic) {
        $list['servicesPet'][$servic->idServic] = array('name' => utf8_encode($servic->nameServic), 'package' => $servic->package);
    }

    foreach ($servicVetList as $servic) {
        $list['servicesVet'][$servic->idServic] = ($servic->nameServic);
    }
    
    echo json_encode($list);

    
} else if ($field == 'save') {

    $idBreed = $_GET['idBreed'];
    $idClient = $_GET['idClient'];
    $idServic = $_GET['idServic'];
    $idServicVet = $_GET['idServicVet'];
    $dateHourPackage = $_GET['dateHourPackage'];

    include_once $path . "/bichoensaboado/dao/DiaryDAO.php";
    include_once $path . "/bichoensaboado/dao/ServicDAO.php";
    include_once $path . "/bichoensaboado/dao/PackageDAO.php";
    include_once $path . "/bichoensaboado/class/PackageClass.php";

    $diaryDao = new DiaryDAO();
    $diaryDao->UpdateCompanion($id, 'true');

    $diaryDao = new DiaryDAO();
    $servicDao = new ServicDAO();
    $packageDao = new PackageDAO();
    $package = new PackageClass();

    if(!empty($idServic))
        $servicClass = $servicDao->SearchId($idServic);
        
    if(!empty($idServicVet))
        $servicVetClass = $servicDao->SearchId($idServicVet);
        

    if(isset($servicClass) && isset($dateHourPackage)){
        foreach ($dateHourPackage as $key => $dateHourItem) {
            $dateHourItem = $dateHourItem['date'] . ' ' . $dateHourItem['hour'];
    
            $date = "date" . ($key + 1);
            $week = "week" . ($key + 1);
            $package->${'date'} = $dateHourItem;
            $package->${'week'} = $key + 1;
    
            $date = "date" . ($key + 3);
            $week = "week" . ($key + 3);
            $package->${'date'} = null;
            $package->${'week'} = 0;
        }
    
        $idPackage = $packageDao->Insert($package);

        $diaryClass = $diaryDao->SearchId($id);
        $diaryClass->servic = empty($idServic) ? null : $idServic;
        $diaryClass->servicVet = empty($idServicVet) ? null : $idServicVet;
        $diaryClass->client = $idClient;
        $diaryClass->deliveryPrice = 0;
        $diaryClass->price = empty($idServic) ? 0 : $servicClass->valuation;
        $diaryClass->priceVet = empty($idServicVet) ? 0 : $servicVetClass->valuation;
        $diaryClass->totalPrice = $diaryClass->price + $diaryClass->priceVet;
        $diaryClass->package = $idPackage;

        foreach ($dateHourPackage as $key => $dateHourItem) {
            $diaryClass->dateHour = $dateHourItem['date'] . ' ' . $dateHourItem['hour'];
            if($key > 0){
                $diaryClass->price = 0;
                $diaryClass->priceVet = 0;
                $diaryClass->totalPrice = 0;
            }
            $idDiaryLast = $diaryDao->Insert($diaryClass);
            $diaryDao = new DiaryDAO();
            $diaryDao->UpdateCompanion($idDiaryLast, $id+$key);
        }
    }else{
        $diaryClass = $diaryDao->SearchId($id);
        $diaryClass->servic = empty($idServic) ? null : $idServic;
        $diaryClass->servicVet = empty($idServicVet) ? null : $idServicVet;
        $diaryClass->client = $idClient;
        $diaryClass->deliveryPrice = 0;
        $diaryClass->price = empty($idServic) ? 0 : $servicClass->valuation;
        $diaryClass->priceVet = empty($idServicVet) ? 0 : $servicVetClass->valuation;
        $diaryClass->totalPrice = $diaryClass->price + $diaryClass->priceVet;
        $diaryClass->package = 0;
        $idDiaryLast = $diaryDao->Insert($diaryClass);
        
        $diaryDao = new DiaryDAO();
        $diaryDao->UpdateCompanion($idDiaryLast, $id);
        
        echo true;
    }

}

