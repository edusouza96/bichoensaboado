
<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
    
    /**
     * Dialog box to alert the user of cashdesk open
     */
    include_once($path."/bichoensaboado/dao/TreasurerDAO.php");
    $treasurerDao = new TreasurerDAO();
    $treasurerDao->addWhere(" SUBSTRING(dateRegistryTreasurer,1,10) = curdate()");// Se tem registro do dia significa que o caixa esta aberto
    $treasurerList = $treasurerDao->searchAll();
    if(empty($treasurerList)){
        $treasurerDao = new TreasurerDAO();
        $treasurerList = $treasurerDao->searchAll();
        echo '{
            "startingMoney":"'.$treasurerList[0]->closingMoneyDayTreasurer.'",
            "isOpen": '.true.'
        }';
    }else{
        echo '{
            "isOpen": 0
        }';
    }
    
?>