
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
        $treasurerDao->addComplement(" ORDER BY dateRegistryTreasurer DESC");
        $treasurerList = $treasurerDao->searchAll();
        if(empty($treasurerList)){
            echo '{
                "startingMoney":"0.00",
                "isOpen": '.true.',
                "isClose": 0,
                "closingMoney": "0.00"
            }';
        }else{

            if($treasurerList[0]->closingMoneyDayTreasurer == null){
                $treasurerDao->closeTreasurer(substr($treasurerList[0]->dateRegistryTreasurer, 0, 10)); 
                
                $treasurerDao = new TreasurerDAO();
                $treasurerDao->addComplement(" ORDER BY dateRegistryTreasurer DESC");
                $treasurerList = $treasurerDao->searchAll();
            }

            echo '{
                "startingMoney":"'.$treasurerList[0]->moneyDrawerTreasurer.'",
                "isOpen": '.true.',
                "isClose": '.$treasurerList[0]->close.',
                "closingMoney": "'.$treasurerList[0]->closingMoneyDayTreasurer.'"
            }';
        }
    }else{
        $treasurerDao = new TreasurerDAO();
        $treasurerDao->addComplement(" ORDER BY dateRegistryTreasurer DESC");
        $treasurerList = $treasurerDao->searchAll();
        $startingMoney = empty($treasurerList) ? '0.00' : $treasurerList[0]->moneyDrawerTreasurer;//24/12/2018 alterei isso de moneyDrawerTreasurer para startingMoneyDayTreasurer. Não sei o impacto dessa mudança
        $closingMoney = empty($treasurerList) ? '0.00' : $treasurerList[0]->closingMoneyDayTreasurer;
        echo '{
            "startingMoney":"'.$startingMoney.'",
            "isOpen": 0,
            "isClose": '.$treasurerList[0]->close.',
            "closingMoney": "'.$closingMoney.'"
        }';
    }
    
?>