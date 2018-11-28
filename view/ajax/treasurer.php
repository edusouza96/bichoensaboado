<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$option = $_GET['option'];

include_once($path."/bichoensaboado/dao/TreasurerDAO.php");

$treasurerDao = new TreasurerDAO();
if($option == 1){
    $treasurerDao->openTreasurer();    
    echo "Caixa aberto!";
}else if($option == 2){
    $treasurerDao->closeTreasurer();    
    echo "Caixa Fechado!";
}
?>