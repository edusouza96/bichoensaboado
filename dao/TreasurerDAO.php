<?php
class TreasurerDAO{

    public static $instance;
    private $sqlWhere = "";
    private $sqlComplement = "";

    public function __construct() {
        $path = $_SERVER['DOCUMENT_ROOT']; 
        include_once($path."/bichoensaboado/class/Conexao.php");  
        include_once($path."/bichoensaboado/class/TreasurerClass.php");
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
                dateRegistryTreasurer
              )VALUES (
                :startingMoneyDayTreasurer,
                :closingMoneyDayTreasurer,
                :moneyDrawerTreasurer,
                :moneySavingsTreasurer,   
                :moneyBankOnlineTreasurer,
                :moneyBankTreasurer,
                :dateRegistryTreasurer
              )";
 
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":startingMoneyDayTreasurer", $treasurer->startingMoneyDayTreasurer);
            $p_sql->bindValue(":closingMoneyDayTreasurer",  $treasurer->closingMoneyDayTreasurer);
            $p_sql->bindValue(":moneyDrawerTreasurer",      $treasurer->moneyDrawerTreasurer);
            $p_sql->bindValue(":moneySavingsTreasurer",     $treasurer->moneySavingsTreasurer);
            $p_sql->bindValue(":moneyBankTreasurer",        $treasurer->moneyBankTreasurer);
            $p_sql->bindValue(":moneyBankOnlineTreasurer",        $treasurer->moneyBankOnlineTreasurer);
            $p_sql->bindValue(":dateRegistryTreasurer",     $treasurer->dateRegistryTreasurer);
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
            $sql = "SELECT * FROM treasurer ORDER BY idTreasurer DESC LIMIT 1";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }    
    }

    public function searchDate($dateRegistryTreasurer) {
        try {
            $sql = "SELECT * FROM treasurer WHERE SUBSTRING(dateRegistryTreasurer, 1, 10) = :dateRegistryTreasurer";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":dateRegistryTreasurer", $dateRegistryTreasurer);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }    
    }

    public function searchAll(){
        try {
            $sql = "SELECT * FROM treasurer WHERE 1=1 ".$this->sqlWhere."".$this->sqlComplement;
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
 
            foreach ($list as $row)
                $f_list[] = $this->showObject($row);
 
            return $f_list;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
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
                dateRegistryTreasurer
              )SELECT 
                moneyDrawerTreasurer, 
                moneyDrawerTreasurer, 
                moneySavingsTreasurer, 
                moneyBankOnlineTreasurer,
                moneyBankTreasurer, 
                NOW() 
              FROM treasurer 
              ORDER BY dateRegistryTreasurer 
              DESC limit 1
            ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            return Conexao::getInstance()->lastInsertId();
        }catch(Exception $e){
            print "Ocorreu um erro ao tentat executar esta ação, tente novamente mais tarde.";
        }
    }
    
    public function closeTreasurer(){
        try{
            // busca os valores do dia 
            $sql = "SELECT 
                        day, 
                        sum(valueInCash) as valueInCash, 
                        sum(valueInCredit) as valueInCredit, 
                        sum(valueOut) as valueOut,
                        ((sum(valueInCredit)+sum(valueInCash)) - sum(valueOut)) as valueDay 
                FROM ( 
                    (SELECT datePayFinancial as day, (valueProduct) AS valueInCash, 0 as valueOut, 0 AS valueInCredit FROM financial WHERE registerBuy IS NOT NULL AND methodPayment = 1)
                    UNION 
                    (SELECT datePayFinancial as day, 0 as valueInCash, (valueProduct) AS valueOut, 0 AS valueInCredit FROM financial WHERE registerBuy IS NULL) 
                        UNION
                        (SELECT datePayFinancial as day, 0 AS valueInCash, 0 as valueOut, (valueProduct) AS valueInCredit FROM financial WHERE registerBuy IS NOT NULL AND methodPayment <> 1)
                ) AS tbl 
                WHERE SUBSTRING(day, 1, 10) = curdate()
                GROUP BY day
            ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            $resultInfosAux = $p_sql->fetch(PDO::FETCH_ASSOC);
            // seta os resultados em variaveis
            $day = $resultInfosAux['day'];
            $valueInCash = $resultInfosAux['valueInCash'];
            $valueInCredit = $resultInfosAux['valueInCredit'];
            $valueOut = $resultInfosAux['valueOut'];
            $valueDay = $resultInfosAux['valueDay'];
            $dateNow = date('Y-m-d H:i:s');
            $treasurerClass = null;
            $error = false;
            // Seta os valores para update caso $day não for vazio, se for significa que o caixa não foi aberto
            if(!empty($day)){
                $treasurerClass = $this->searchDate($day);
                $treasurerClass->closingMoneyDayTreasurer = $valueDay;
                $treasurerClass->moneyDrawerTreasurer += ($valueInCash-$valueOut);
                $treasurerClass->moneyBankOnlineTreasurer += $valueInCredit;
                $treasurerClass->dateRegistryTreasurer = $dateNow;
            }
            //Se $treasurerClass não for null é pq não deu erro no processo
            if(!is_null($treasurerClass)){
                $error = $this->update($treasurerClass);
            }
            return $error;
        }catch(Exception $e){
            print "Ocorreu um erro ao tentar executar ação, tente novamente mais tarde.";
        }
    }

    private function showObject($row){
        $treasurerClass = new TreasurerClass();
        foreach($row as $field => $value){
            $treasurerClass->${'field'} = $value;    
        }
        return $treasurerClass;
    }

}
?>