<?php
  $idFinancial = $_POST['idFinancial'];
  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/FinancialDAO.php");
  include_once($path."/bichoensaboado/dao/SalesDAO.php");
  include_once($path."/bichoensaboado/dao/ProductDAO.php");
  
  
  $financialDao = new FinancialDAO();
  $financial = $financialDao->searchId($idFinancial);
  $response = $financialDao->delete($idFinancial);
  
  $salesDao = new SalesDAO();
  $sales = $salesDao->searchId($financial->sales);
  $response = $salesDao->delete($financial->sales);

  $productDao = new ProductDAO();
  $response = $productDao->updateQuantity($sales->productSales, $sales->quantityProductSales, true);
  
  echo $response;    
?>

