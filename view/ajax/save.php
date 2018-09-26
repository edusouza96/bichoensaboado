<?php
date_default_timezone_set('America/Sao_Paulo');

$idFieldParam = $_GET['idField'];
$ownerParam = $_GET['owner'];
$searchParam = $_GET['search'];
$serviceParam = empty($_GET['service']) ? null : $_GET['service'];
$priceParam = empty($_GET['price']) ? 0 : $_GET['price'];
$serviceVetParam = empty($_GET['serviceVet']) ? null : $_GET['serviceVet'];
$priceVetParam = empty($_GET['priceVet']) ? 0 : $_GET['priceVet'];
$deliveryPriceParam = $_GET['deliveryPrice'];
$totalPriceParam = $_GET['totalPrice'];
$dateHourParam = $_GET['dateHour'];
$dateHourPackageParam = $_GET['dateHourPackage'];

$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path . "/bichoensaboado/dao/DiaryDAO.php";
include_once $path . "/bichoensaboado/class/DiaryClass.php";
include_once $path . "/bichoensaboado/dao/ServicDAO.php";
include_once $path . "/bichoensaboado/dao/PackageDAO.php";
include_once $path . "/bichoensaboado/class/PackageClass.php";

$package = new PackageClass();
$packageDao = new PackageDAO();

$servicDao = new ServicDAO();
$servic = $servicDao->SearchId($serviceParam);

if ($servic->package > 0) {
    foreach ($dateHourPackageParam as $key => $dateHourItem) {
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

    foreach ($dateHourPackageParam as $key => $dateHourItem) {
        $dateHourItem = $dateHourItem['date'] . ' ' . $dateHourItem['hour'];
        $diary = new DiaryClass();
        $diary->DiaryClass(0
            , $ownerParam
            , $searchParam
            , $serviceParam
            , $priceParam
            , $serviceVetParam
            , $priceVetParam
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
} else if ($servic->package == 0) {
    $diary = new DiaryClass();
    $diary->DiaryClass(
        0,
        $ownerParam,
        $searchParam,
        $serviceParam,
        $priceParam,
        $serviceVetParam,
        $priceVetParam,
        $deliveryPriceParam,
        $totalPriceParam,
        $dateHourParam,
        0
    );

    $diaryDao = new DiaryDAO();
    $response = $diaryDao->Insert($diary);
}

echo $response;
