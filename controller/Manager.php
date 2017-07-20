<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/ClientDAO.php");
    include_once($path."/bichoensaboado/class/ClientClass.php");
    include_once($path."/bichoensaboado/dao/ServicDAO.php");
    include_once($path."/bichoensaboado/class/ServicClass.php");
    include_once($path."/bichoensaboado/dao/BreedDAO.php");
    include_once($path."/bichoensaboado/class/BreedClass.php");
    include_once($path."/bichoensaboado/dao/AddressDAO.php");
    include_once($path."/bichoensaboado/class/AddressClass.php");
    include_once($path."/bichoensaboado/dao/FinancialDAO.php");
    include_once($path."/bichoensaboado/class/FinancialClass.php");
    include_once($path."/bichoensaboado/dao/ProductDAO.php");
    include_once($path."/bichoensaboado/class/ProductClass.php");
    include_once($path."/bichoensaboado/dao/SalesDAO.php");
    include_once($path."/bichoensaboado/class/SalesClass.php");
    $clientClass = new ClientClass();
    $clientDao = new ClientDAO();
    $servicClass = new ServicClass();
    $servicDao = new ServicDAO();
    $breedClass = new BreedClass();
    $breedDao = new BreedDAO();
    $addressClass = new AddressClass();
    $addressDao = new AddressDAO();
    $productClass = new ProductClass();
    $productDao = new ProductDAO();
    $salesClass = new SalesClass();
    $salesDao = new SalesDAO();
    $financialClass = new FinancialClass();
    $financialDao = new FinancialDAO();
    $module = $_POST['module'];

    switch ($module) {
        case 'client':
            $nameAnimal = array();
            $breed = array();
            $idCliente =array();
             
            foreach($_POST as $fieldKey=>$fieldValue){
                if(${'fieldKey'} != 'module' || ${'fieldKey'} != 'nameAnimal' || ${'fieldKey'} != 'breed' || ${'fieldKey'} != 'idClient'){
                    $clientClass->${'fieldKey'} = $fieldValue;
                }
                if(${'fieldKey'} == 'nameAnimal'){
                    $numberClient = count($fieldValue);
                    $nameAnimal = $fieldValue;
                }
                if(${'fieldKey'} == 'breed'){
                    $breed = $fieldValue;
                }
                if(${'fieldKey'} == 'idClient'){
                    $idCliente = $fieldValue;
                }
            }
           
            for($i=0; $i<$numberClient; $i++){
                $clientClass->idClient = $idCliente[$i];
                $clientClass->nameAnimal = $nameAnimal[$i];
                $clientClass->breed = $breed[$i];
                if($clientClass->idClient != 0){
                    $clientDao->Update($clientClass);
                }else{
                    $clientDao->Insert($clientClass);
                }
            }
            
            break;

        case 'servic':
            foreach($_POST as $fieldKey=>$fieldValue){
                if(${'fieldKey'} != 'module'){
                    $servicClass->${'fieldKey'} = $fieldValue;
                }
            }
            if($servicClass->idServic != 0){
                $servicDao->Update($servicClass);
            }else{
                $servicDao->Insert($servicClass);
            }
            
            break;

        case 'breed':
            foreach($_POST as $fieldKey=>$fieldValue){
                if(${'fieldKey'} != 'module'){
                    $breedClass->${'fieldKey'} = $fieldValue;
                }
            }
            if($breedClass->idBreed != 0){
                $breedDao->Update($breedClass);
            }else{
                $idBreed = $breedDao->Insert($breedClass);
                $servicDao->InsertDefaultBreed($idBreed);
            }
            break;

        case 'address':
            foreach($_POST as $fieldKey=>$fieldValue){
                if(${'fieldKey'} != 'module'){
                    $addressClass->${'fieldKey'} = $fieldValue;
                }
            }
            if($addressClass->idAddress != 0){
                $addressDao->Update($addressClass);
            }else{
                $addressDao->Insert($addressClass);
            }
            
            break;

        case 'financial':
            foreach($_POST as $fieldKey=>$fieldValue){
                if(${'fieldKey'} != 'module'){
                    $financialClass->${'fieldKey'} = $fieldValue;
                }
            }
        
            if($financialClass->idFinancial != 0){
                $financialDao->update($financialClass);
            }else{
                $financialDao->insert($financialClass);
            }
            break;

        case 'product':
            foreach($_POST as $fieldKey=>$fieldValue){
                if(${'fieldKey'} != 'module'){
                    $productClass->${'fieldKey'} = $fieldValue;
                }
            }
            if($productClass->idProduct != 0){
                $productDao->update($productClass);
            }else{
               $productDao->insert($productClass);
            }
            
            break;
        
        case 'sales':
            
            if($_POST['idSales'] > 0){
                // $salesDao->update($salesClass);
            }else{
                $quantityProductSales = $_POST['quantityProductSales'];
                $productSales         = $_POST['productSales'];
                $valuationUnitSales   = $_POST['valuationUnitSales'];
                $saleIds = array();
                for($i=0; $i<count($productSales); $i++){
                    $salesClass = new SalesClass();
                    $salesClass->quantityProductSales = $quantityProductSales[$i];
                    $salesClass->valuationUnitSales   = $valuationUnitSales[$i];
                    $salesClass->productSales         = $productSales[$i];
                    $saleIds[] = $salesDao->insert($salesClass);
                }

                $registerBuy = date('YmdHis');
                for($i=0; $i<count($saleIds); $i++){
                    $financialClass = new FinancialClass();
                    $financialClass->registerBuy = "".$registerBuy;
                    $financialClass->sales = $saleIds[$i];
                    $financialClass->valueProduct = $quantityProductSales[$i] * $valuationUnitSales[$i];
                    $financialClass->description = "Entrada no caixa";
                    $financialClass->dateDueFinancial = date('Y-m-d');
                    $financialClass->datePayFinancial = date('Y-m-d');
                    print_r($financialDao->insert($financialClass));
                }
            }
            break;

        default:
            echo "ERROU!";
            break;
    }
    header("location:../view/".$module."/index.php");
?>