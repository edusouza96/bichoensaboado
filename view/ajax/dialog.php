<?php
    $barcodeProduct = $_GET['barcodeProduct'];
    $quantityProduct = $_GET['quantityProduct'];
    $valuationProduct = $_GET['valuationProduct'];
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/ProductDAO.php");
    include_once($path."/bichoensaboado/class/ProductClass.php");
    $productClass = new ProductClass();
    $productDao = new ProductDAO();
    $productDao->addWhere('barcodeProduct = '.$barcodeProduct);
    $productList = $productDao->searchAll();
    if(count($productList) > 0){
        $productClass = $productList[0];
        $quantityOld = $productClass->quantityProduct; 
        $valuationOld = $productClass->valuationProduct; 
        $valuationExpectedOld = $quantityOld * $valuationOld;
        $quantityNew = $quantityProduct; 
        $valuationNew = $valuationProduct; 
        $valuationExpectedNew = $quantityNew * $valuationNew;
        $valuationUnitNew = ($valuationExpectedOld + $valuationExpectedNew) / ($quantityOld + $quantityNew);
        echo  "Atualmente existe em estoque ".$quantityOld." unidades, com o valor para venda de R$".number_format($valuationOld,2,",",".")."
        <br>Melhor preço adequado para este produto R$".number_format($valuationUnitNew,2,",",".");
    }else{
        echo "0";
    }
    
?>