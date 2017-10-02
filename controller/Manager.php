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
    include_once($path."/bichoensaboado/dao/DiaryDAO.php");
    include_once($path."/bichoensaboado/class/DiaryClass.php");
    include_once($path."/bichoensaboado/dao/CategoryExpenseFinancialDAO.php");
    include_once($path."/bichoensaboado/class/CategoryExpenseFinancialClass.php");
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
    $diaryClass = new DiaryClass();
    $diaryDao = new DiaryDAO();
    $categoryExpenseFinancialClass = new CategoryExpenseFinancialClass();
    $categoryExpenseFinancialDAO = new CategoryExpenseFinancialDAO();
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
            $valuationUnitNew = 0;
            foreach($_POST as $fieldKey=>$fieldValue){
                if(${'fieldKey'} != 'module'){
                    $productClass->${'fieldKey'} = $fieldValue;
                }
            }

            if($_POST['optionActionProduct'] > 0){
                $productAuxDao = new ProductDAO();
                $productAuxDao->addWhere('barcodeProduct = '.$_POST['barcodeProduct']);
                $productAuxList = $productAuxDao->searchAll();
                if(count($productAuxList) > 0){
                    $productAuxClass = $productAuxList[0];
                    $quantityOld = $productAuxClass->quantityProduct; 
                    $valuationOld = $productAuxClass->valuationProduct; 
                    $valuationExpectedOld = $quantityOld * $valuationOld;
                    $quantityNew = $_POST['quantityProduct']; 
                    $valuationNew = $_POST['valuationProduct']; 
                    $valuationExpectedNew = $quantityNew * $valuationNew;
                    $valuationUnitNew = ($valuationExpectedOld + $valuationExpectedNew) / ($quantityOld + $quantityNew);

                    $productClass->idProduct = $productAuxClass->idProduct;
                    $productClass->quantityProduct = ($quantityNew + $quantityOld);
                }
                
                // caso esteja cadastrando um produto existente, o sistema faz um calculo para do valor de venda de acordo com o valor inserido e o valor anterior
                if($_POST['optionActionProduct'] == 2){
                    $productClass->valuationProduct = $valuationUnitNew;
                }
                $idProductSucess = $productDao->update($productClass);
                if($idProductSucess){
                    $quantity = $quantityNew;
                    $valueUnit = $productClass->valuationBuyProduct;
                    $description = $productClass->nameProduct;
                    $financialClass = new FinancialClass();
                    $financialClass->description              = 'Compra de produtos: '.$quantity. ' unidades de '.$description;
                    $financialClass->dateDueFinancial         = date('Y-m-d');
                    $financialClass->datePayFinancial         = date('Y-m-d');
                    $financialClass->valueProduct             = $quantity * $valueUnit;
                    $financialClass->categoryExpenseFinancial = 4;
                    $financialDao = new FinancialDao();
                    $financialDao->insert($financialClass);
                }
            }else{
                // caso seja um update ou insert, segue o fluxo padrão
                if($productClass->idProduct != 0){
                    $productDao->update($productClass);
                }else{
                    $idProductSucess = $productDao->insert($productClass);
                    if($idProductSucess){
                        $quantity = $productClass->quantityProduct;
                        $valueUnit = $productClass->valuationBuyProduct;
                        $description = $productClass->nameProduct;
                        $financialClass = new FinancialClass();
                        $financialClass->description              = 'Compra de produtos: '.$quantity. 'unidades de '.$description;
                        $financialClass->dateDueFinancial         = date('Y-m-d');
                        $financialClass->datePayFinancial         = date('Y-m-d');
                        $financialClass->valueProduct             = $quantity * $valueUnit;
                        $financialClass->categoryExpenseFinancial = 4;
                        $financialDao = new FinancialDao();
                        $financialDao->insert($financialClass);
                    }
                }
            }
            
            break;
        
        case 'sales':

            if($_POST['idSales'] > 0){
                // $salesDao->update($salesClass);
            }else{
                $quantityProductSales = $_POST['quantityProductSales'];
                $productSales         = $_POST['productSales'];
                $valuationUnitSales   = $_POST['valuationUnitSales'];
                @$diarySales          = $_POST['diarySales'];
                $methodPayment        = $_POST['methodPayment'];
                $totalBuy             = $_POST['totalBuy'];
                $valueReceive         = $_POST['valueReceive'];
                $rebate               = $_POST['rebate'];
                $change               = $_POST['change'];
                
                
                $saleIds = array();
                for($i=0; $i<count($valuationUnitSales); $i++){
                    $salesClass = new SalesClass();
                    $salesClass->quantityProductSales = $quantityProductSales[$i];
                    $salesClass->valuationUnitSales   = $valuationUnitSales[$i];
                    $salesClass->productSales         = $productSales[$i];
                    @$salesClass->diarySales           = $diarySales[$i];
                    $saleIds[] = $salesDao->insert($salesClass);
                    if($productSales[$i] > 0){
                        $productUpDao = new ProductDAO();
                        $productUpDao->updateQuantity($productSales[$i], $quantityProductSales[$i]);
                    }
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
                    $financialClass->methodPayment = $methodPayment;
                    ($financialDao->insert($financialClass));
                }
                // print invoice
                include_once($path."/bichoensaboado/view/sales/invoice.php");                
            }
            break;

        case 'treasurer':
            foreach($_POST as $fieldKey=>$fieldValue){
                if(${'fieldKey'} != 'module'){
                    $financialClass->${'fieldKey'} = $fieldValue;
                }
            }
        
            if($treasurerClass->idTreasurer != 0){
                $treasurerDao->update($treasurerClass);
            }else{
                $treasurerDao->insert($treasurerClass);
            }
            break;    
 
        default:
            echo "ERROU!";
            break;
    }
    header("location:../view/".$module."/index.php");
?>
