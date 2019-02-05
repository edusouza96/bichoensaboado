<?php

class TreasurerDAO{

    public static $instance;
    private $sqlWhere = "";
    private $sqlComplement = "";

    public function __construct() {
        $path = $_SERVER['DOCUMENT_ROOT']; 
        include_once($path."/bichoensaboado/class/Conexao.php");  
        include_once($path."/bichoensaboado/class/TreasurerClass.php");
        include_once($path."/bichoensaboado/class/LoginClass.php");
        include_once $path."/bichoensaboado/view/inc/util.php";
    }
 
    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new TreasurerDAO();
        return self::$instance;
    }

    public function insert(TreasurerClass $treasurer){
        try {
            $sql = "INSERT INTO treasurer (   
                startingMoneyDayTreasurer,
                closingMoneyDayTreasurer,
                moneyDrawerTreasurer,
                moneySavingsTreasurer,   
                moneyBankOnlineTreasurer,
                moneyBankTreasurer,
                dateRegistryTreasurer,
                store
              )VALUES (
                :startingMoneyDayTreasurer,
                :closingMoneyDayTreasurer,
                :moneyDrawerTreasurer,
                :moneySavingsTreasurer,   
                :moneyBankOnlineTreasurer,
                :moneyBankTreasurer,
                :dateRegistryTreasurer,
                :store
              )";
 
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":startingMoneyDayTreasurer", $treasurer->startingMoneyDayTreasurer);
            $p_sql->bindValue(":closingMoneyDayTreasurer",  $treasurer->closingMoneyDayTreasurer);
            $p_sql->bindValue(":moneyDrawerTreasurer",      $treasurer->moneyDrawerTreasurer);
            $p_sql->bindValue(":moneySavingsTreasurer",     $treasurer->moneySavingsTreasurer);
            $p_sql->bindValue(":moneyBankTreasurer",        $treasurer->moneyBankTreasurer);
            $p_sql->bindValue(":moneyBankOnlineTreasurer",  $treasurer->moneyBankOnlineTreasurer);
            $p_sql->bindValue(":dateRegistryTreasurer",     $treasurer->dateRegistryTreasurer);
            $p_sql->bindValue(":store",                     getStore());
            $p_sql->execute();
            return Conexao::getInstance()->lastInsertId();
            
        } catch (Exception $e) {
            print $e."Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }      
    }

    public function update(TreasurerClass $treasurer){
        try{
            $sql = "UPDATE treasurer set idTreasurer = :idTreasurer";
            $treasurerList = $treasurer->iterateVisible();
            foreach($treasurerList as $key => $value){
              if($value != ""){
                  $sql .= ", ".$key." = '".$value."'";
              }
            }
            $sql .= " WHERE idTreasurer = :idTreasurer";
           
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idTreasurer",  $treasurer->idTreasurer);
            return $p_sql->execute();

        }catch(Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function updateFinancial($idTreasurer, $date){
        try{
            $sql = "UPDATE financial set treasurer_idTreasurer = :idTreasurer WHERE store = ".getStore()." AND  registerBuy IS NOT NULL AND methodPayment = 1 AND treasurer_idTreasurer IS NULL AND  SUBSTRING(datePayFinancial, 1, 10) = :date";
           
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idTreasurer",  $idTreasurer);
            $p_sql->bindValue(":date",  $date);
            return $p_sql->execute();

        }catch(Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function delete($idTreasurer) {
        try {
            $sql = "DELETE FROM treasurer WHERE idTreasurer = :idTreasurer";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idTreasurer", $idTreasurer);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function addWhere($value){
        $this->sqlWhere .= 'AND '.$value;
    }

    public function addComplement($value){
        $this->sqlComplement .= ' '.$value;
    }

    public function searchId($idTreasurer) {
        try {
            $sql = "SELECT * FROM treasurer WHERE idTreasurer = :idTreasurer";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idTreasurer", $idTreasurer);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }    
    }

    public function searchLastId() {
        try {
            $sql = "SELECT * FROM treasurer WHERE store = ".getStore()." ORDER BY idTreasurer DESC LIMIT 1";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();

            $fetchArray = $p_sql->fetch(PDO::FETCH_ASSOC);
            if($fetchArray){
                return $this->showObject($fetchArray);
            }else{
                return null;
            }
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.#TDSLI";
        }    
    }

    public function searchDate($dateRegistryTreasurer) {
        try {
            $sql = "SELECT * FROM treasurer WHERE store = :store AND SUBSTRING(dateRegistryTreasurer, 1, 10) = :dateRegistryTreasurer ORDER BY dateRegistryTreasurer DESC";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":store", getStore());
            $p_sql->bindValue(":dateRegistryTreasurer", $dateRegistryTreasurer);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.#TDSD";
        }    
    }

    public function searchAll(){
        try {
            $sql = "SELECT * FROM treasurer WHERE store = :store ".$this->sqlWhere." ".$this->sqlComplement;
            $result = Conexao::getInstance()->prepare($sql);
            $result->bindValue(":store", getStore());
            $result->execute();
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
 
            foreach ($list as $row)
                $f_list[] = $this->showObject($row);
 
            return $f_list;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.#TDSA";
        }
    }

    public function openTreasurer(){
        try{
            $sql= "INSERT INTO treasurer (
                startingMoneyDayTreasurer, 
                moneyDrawerTreasurer, 
                moneySavingsTreasurer, 
                moneyBankOnlineTreasurer, 
                moneyBankTreasurer, 
                dateRegistryTreasurer,
                store
              )SELECT 
                moneyDrawerTreasurer, 
                moneyDrawerTreasurer, 
                moneySavingsTreasurer, 
                moneyBankOnlineTreasurer,
                moneyBankTreasurer, 
                NOW(),
                :store
              FROM treasurer 
              WHERE store = :store
              ORDER BY dateRegistryTreasurer 
              DESC limit 1
            ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":store", getStore());
            $p_sql->execute();
            return Conexao::getInstance()->lastInsertId();
        }catch(Exception $e){
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
    
    public function closeTreasurer($dateClose = null){
        try{
            if($dateClose == null){
                $dateClose = date('Y-m-d');
            }

            // busca os valores do dia 
            $sql = "SELECT 
                    day, 
                    SUM(valueInCash) as valueInCash, 
                    SUM(valueInCredit) as valueInCredit, 
                    SUM(valueOutDrawer) as valueOutDrawer,
                    SUM(valueOutSavings) as valueOutSavings,
                    SUM(valueOutBankOnline) as valueOutBankOnline,
                    SUM(valueOutBank) as valueOutBank,
                    (
                        (SUM(valueInCredit)+SUM(valueInCash)) 
                        - 
                        (SUM(valueOutDrawer)+SUM(valueOutSavings)+SUM(valueOutBankOnline)+SUM(valueOutBank))
                    ) as valueDay 
                FROM (
                    (SELECT datePayFinancial as day, (valueProduct) AS valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NOT NULL AND methodPayment = 1 AND treasurer_idTreasurer IS NULL)
                        UNION 
                    (SELECT datePayFinancial as day, 0 as valueInCash, (valueProduct) AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank , 0 AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NULL AND typeTreasurerFinancial = 1) 
                        UNION
                    (SELECT datePayFinancial as day, 0 as valueInCash, 0 AS valueOutDrawer, (valueProduct) AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NULL AND typeTreasurerFinancial = 2) 
                        UNION
                    (SELECT datePayFinancial as day, 0 as valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, (valueAliquot) AS valueOutBankOnline, 0 AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NULL AND typeTreasurerFinancial = 3) 
                        UNION
                    (SELECT datePayFinancial as day, 0 as valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, (valueProduct) AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NULL AND typeTreasurerFinancial = 4) 
                        UNION
                    (SELECT datePayFinancial as day, 0 AS valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank, (valueProduct) AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NOT NULL AND methodPayment <> 1 AND treasurer_idTreasurer IS NULL)
                ) AS tbl 
                WHERE SUBSTRING(day, 1, 10) = '".$dateClose."'
                GROUP BY day
            ";

            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            $resultInfosAux = $p_sql->fetch(PDO::FETCH_ASSOC);
            // seta os resultados em variaveis
            $day = $resultInfosAux['day'];
            $valueInCash = $resultInfosAux['valueInCash'];
            $valueInCredit = $resultInfosAux['valueInCredit'];
            $valueOutDrawer = $resultInfosAux['valueOutDrawer'];
            $valueOutSavings = $resultInfosAux['valueOutSavings'];
            $valueOutBankOnline = $resultInfosAux['valueOutBankOnline'];
            $valueOutBank = $resultInfosAux['valueOutBank'];
            $valueDay = $resultInfosAux['valueDay'];
            // $dateNow = date('Y-m-d H:i:s');
            $treasurerClass = null;
            $error = false;

            // Seta os valores para update caso $day não for vazio, se for significa que o caixa não foi aberto
            $dateNow = date('Y-m-d');
            $treasurerClass = $this->searchDate($dateNow);
            $treasurerClass->closingMoneyDayTreasurer = $valueInCash;
            $treasurerClass->moneyDrawerTreasurer += ($valueInCash-$valueOutDrawer);
            $treasurerClass->moneySavingsTreasurer -= $valueOutSavings;
            $treasurerClass->moneyBankOnlineTreasurer += ($valueInCredit-$valueOutBankOnline);
            $treasurerClass->moneyBankTreasurer -= $valueOutBank;
            $treasurerClass->close = 1;
            // $treasurerClass->dateRegistryTreasurer = $dateNow;

            //Se $treasurerClass não for null é pq não deu erro no processo
            if(!is_null($treasurerClass)){
                $error = $this->update($treasurerClass);
            }

            $this->updateFinancial($treasurerClass->idTreasurer, $dateClose);
            return $error;
        }catch(Exception $e){
            print "Ocorreu um erro ao tentar executar ação, tente novamente mais tarde.";
        }
        /**
         * TODO::O que fazer
         * pegar todas as vendas e vincular com treasurer, para na hora de buscar os dados desconsiderar os vinculados
         */
    }

    public function valuesOfDay($days = 1, $valueContribution = 0){
        try{
            $store = getStore();
            
            // busca os valores do dia 
            $sql = "SELECT 
                    group_concat(idFinancial),
                    MAX(day) as day, 
                    SUM(valueInCash) as valueInCash, 
                    SUM(valueInCredit) as valueInCredit, 
                    SUM(valueOutDrawer) as valueOutDrawer,
                    SUM(valueRectify) as valueRectify,
                    SUM(valueOutSavings) as valueOutSavings,
                    SUM(valueOutBankOnline) as valueOutBankOnline,
                    SUM(valueOutBank) as valueOutBank,
                    (
                        (SUM(valueInCredit)+SUM(valueInCash)) 
                        - 
                        (SUM(valueOutDrawer)+SUM(valueOutSavings)+SUM(valueOutBankOnline)+SUM(valueOutBank))
                    ) as valueDay 
                FROM (
                    (SELECT idFinancial, datePayFinancial as day, 0 AS valueRectify, (valueProduct) AS valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".$store." AND registerBuy IS NOT NULL AND methodPayment = 1)
                        UNION 
                    (SELECT idFinancial, datePayFinancial as day, (valueProduct) AS valueRectify, 0 as valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank , 0 AS valueInCredit FROM financial WHERE store = ".$store." AND registerBuy IS NULL AND typeTreasurerFinancial = 1 AND center_cost_idCenterCost = 16 ORDER BY idFinancial DESC LIMIT 1) 
                        UNION 
                    (SELECT idFinancial, datePayFinancial as day, 0 AS valueRectify, 0 as valueInCash, (valueProduct) AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank , 0 AS valueInCredit FROM financial WHERE store = ".$store." AND registerBuy IS NULL AND typeTreasurerFinancial = 1 AND center_cost_idCenterCost <> 16) 
                        UNION
                    (SELECT idFinancial, datePayFinancial as day, 0 AS valueRectify, 0 as valueInCash, 0 AS valueOutDrawer, (valueProduct) AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".$store." AND registerBuy IS NULL AND typeTreasurerFinancial = 2) 
                        UNION
                    (SELECT idFinancial, datePayFinancial as day, 0 AS valueRectify, 0 as valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, (valueAliquot) AS valueOutBankOnline, 0 AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".$store." AND registerBuy IS NULL AND typeTreasurerFinancial = 3) 
                        UNION
                    (SELECT idFinancial, datePayFinancial as day, 0 AS valueRectify, 0 as valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, (valueProduct) AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".$store." AND registerBuy IS NULL AND typeTreasurerFinancial = 4) 
                        UNION
                    (SELECT idFinancial, datePayFinancial as day, 0 AS valueRectify, 0 AS valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank, (valueProduct) AS valueInCredit FROM financial WHERE store = ".$store." AND registerBuy IS NOT NULL AND methodPayment <> 1)
                ) AS tbl 
                WHERE SUBSTRING(day, 1, 10) > DATE_ADD(DATE(CURRENT_TIMESTAMP), INTERVAL -$days DAY)
            ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            $resultInfosAux = $p_sql->fetch(PDO::FETCH_ASSOC);

            // seta os resultados em variaveis
            $day = $resultInfosAux['day'];
            $valueInCash = $resultInfosAux['valueInCash'];
            $valueInCredit = $resultInfosAux['valueInCredit'];
            $valueRectify = $resultInfosAux['valueRectify'];
            $valueOutDrawer = $resultInfosAux['valueOutDrawer'];
            $valueOutSavings = $resultInfosAux['valueOutSavings'];
            $valueOutBankOnline = $resultInfosAux['valueOutBankOnline'];
            $valueOutBank = $resultInfosAux['valueOutBank'];
            $valueDay = $resultInfosAux['valueDay'];

            $treasurerClass = null;
            $error = false;

            // Seta os valores para update caso $day não for vazio, se for significa que o caixa não foi aberto
            if(!empty($day)){
                $treasurerClass = $this->searchLastId();
                $dateRegistryTreasurer = $treasurerClass->dateRegistryTreasurer;
                $id = $treasurerClass->idTreasurer;
                $startingMoneyDayTreasurer = $treasurerClass->startingMoneyDayTreasurer;

                $treasurerClass = $this->searchLastId();
                $treasurerClass->idTreasurer = null;
                $treasurerClass->startingMoneyDayTreasurer = $startingMoneyDayTreasurer + $valueContribution;
                if($treasurerClass->closingMoneyDayTreasurer > 0)
                    $treasurerClass->closingMoneyDayTreasurer = $valueDay;
                $treasurerClass->moneyDrawerTreasurer += ($valueInCash-$valueOutDrawer-$valueRectify);
                $treasurerClass->moneySavingsTreasurer -= $valueOutSavings;
                $treasurerClass->moneyBankOnlineTreasurer += ($valueInCredit-$valueOutBankOnline);
                $treasurerClass->moneyBankTreasurer -= $valueOutBank;
                $treasurerClass->dateRegistryTreasurer = $dateRegistryTreasurer;

                $this->delete($id);  

                
            }
            //Se $treasurerClass não for null é pq não deu erro no processo
            if(!is_null($treasurerClass)){
                $error = $this->insert($treasurerClass);
            }
            return $error;
        }catch(Exception $e){
            print "Ocorreu um erro ao tentar executar ação, tente novamente mais tarde.";
        }
    }

    public function calcDrawer($dateClose = null){
        // metodo replicado só pra poder pegar o valor em gaveta
        try{
            if($dateClose == null){
                $dateClose = date('Y-m-d');
            }

            // busca os valores do dia 
            $sql = "SELECT 
                    day, 
                    SUM(valueInCash) as valueInCash, 
                    SUM(valueInCredit) as valueInCredit, 
                    SUM(valueOutDrawer) as valueOutDrawer,
                    SUM(valueOutSavings) as valueOutSavings,
                    SUM(valueOutBankOnline) as valueOutBankOnline,
                    SUM(valueOutBank) as valueOutBank,
                    (
                        (SUM(valueInCredit)+SUM(valueInCash)) 
                        - 
                        (SUM(valueOutDrawer)+SUM(valueOutSavings)+SUM(valueOutBankOnline)+SUM(valueOutBank))
                    ) as valueDay 
                FROM (
                    (SELECT datePayFinancial as day, (valueProduct) AS valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NOT NULL AND methodPayment = 1 AND treasurer_idTreasurer IS NULL)
                        UNION 
                    (SELECT datePayFinancial as day, 0 as valueInCash, (valueProduct) AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank , 0 AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NULL AND typeTreasurerFinancial = 1) 
                        UNION
                    (SELECT datePayFinancial as day, 0 as valueInCash, 0 AS valueOutDrawer, (valueProduct) AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NULL AND typeTreasurerFinancial = 2) 
                        UNION
                    (SELECT datePayFinancial as day, 0 as valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, (valueAliquot) AS valueOutBankOnline, 0 AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NULL AND typeTreasurerFinancial = 3) 
                        UNION
                    (SELECT datePayFinancial as day, 0 as valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, (valueProduct) AS valueOutBank, 0 AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NULL AND typeTreasurerFinancial = 4) 
                        UNION
                    (SELECT datePayFinancial as day, 0 AS valueInCash, 0 AS valueOutDrawer, 0 AS valueOutSavings, 0 AS valueOutBankOnline, 0 AS valueOutBank, (valueProduct) AS valueInCredit FROM financial WHERE store = ".getStore()." AND  registerBuy IS NOT NULL AND methodPayment <> 1 AND treasurer_idTreasurer IS NULL)
                ) AS tbl 
                WHERE SUBSTRING(day, 1, 10) = '".$dateClose."'
                GROUP BY day
            ";

            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            $resultInfosAux = $p_sql->fetch(PDO::FETCH_ASSOC);
            // seta os resultados em variaveis
            $day = $resultInfosAux['day'];
            $valueInCash = $resultInfosAux['valueInCash'];
            $valueInCredit = $resultInfosAux['valueInCredit'];
            $valueOutDrawer = $resultInfosAux['valueOutDrawer'];
            $valueOutSavings = $resultInfosAux['valueOutSavings'];
            $valueOutBankOnline = $resultInfosAux['valueOutBankOnline'];
            $valueOutBank = $resultInfosAux['valueOutBank'];
            $valueDay = $resultInfosAux['valueDay'];

            // Seta os valores para update caso $day não for vazio, se for significa que o caixa não foi aberto
            $dateNow = date('Y-m-d');
            $treasurerClass = $this->searchDate($dateNow);
            $treasurerClass->moneyDrawerTreasurer += ($valueInCash-$valueOutDrawer);

            return $treasurerClass->moneyDrawerTreasurer;
        }catch(Exception $e){
            print "Ocorreu um erro ao tentar executar ação, tente novamente mais tarde.";
        }
        /**
         * TODO::O que fazer
         * pegar todas as vendas e vincular com treasurer, para na hora de buscar os dados desconsiderar os vinculados
         */
    }

    private function showObject($row){
        $treasurerClass = new TreasurerClass();
        $treasurerClass->idTreasurer = $row['idTreasurer'];
        $treasurerClass->startingMoneyDayTreasurer = $row['startingMoneyDayTreasurer'];
        $treasurerClass->closingMoneyDayTreasurer = $row['closingMoneyDayTreasurer'];
        $treasurerClass->moneyDrawerTreasurer = $row['moneyDrawerTreasurer'];
        $treasurerClass->moneySavingsTreasurer = $row['moneySavingsTreasurer'];
        $treasurerClass->moneyBankOnlineTreasurer = $row['moneyBankOnlineTreasurer'];
        $treasurerClass->moneyBankTreasurer = $row['moneyBankTreasurer'];
        $treasurerClass->dateRegistryTreasurer = $row['dateRegistryTreasurer'];
        $treasurerClass->store = $row['store'];
        $treasurerClass->close = $row['close'];
        return $treasurerClass;
    }

}
?> 