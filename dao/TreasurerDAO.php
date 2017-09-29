<?php
class TreasurerDAO{
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
                moneyBankTreasurer,
                dateRegistryTreasurer
              )VALUES (
                :startingMoneyDayTreasurer,
                :closingMoneyDayTreasurer,
                :moneyDrawerTreasurer,
                :moneySavingsTreasurer,   
                :moneyBankTreasurer,
                :dateRegistryTreasurer
              )";
 
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":startingMoneyDayTreasurer", $treasurer->startingMoneyDayTreasurer);
            $p_sql->bindValue(":closingMoneyDayTreasurer",  $treasurer->closingMoneyDayTreasurer);
            $p_sql->bindValue(":moneyDrawerTreasurer",      $treasurer->moneyDrawerTreasurer);
            $p_sql->bindValue(":moneySavingsTreasurer",     $treasurer->moneySavingsTreasurer);
            $p_sql->bindValue(":moneyBankTreasurer",        $treasurer->moneyBankTreasurer);
            $p_sql->bindValue(":dateRegistryTreasurer",     $treasurer->dateRegistryTreasurer);
            $p_sql->execute();
            return Conexao::getInstance()->lastInsertId();
            
        } catch (Exception $e) {
            print $e."Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
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
            print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
        }
    }

    public function delete($idTreasurer) {
        try {
            $sql = "DELETE FROM treasurer WHERE idTreasurer = :idTreasurer";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idTreasurer", $idTreasurer);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
        }
    }

    public function addWhere($value){
        $this->sqlWhere .= 'AND '.$value;
    }

    public function searchId($idTreasurer) {
        try {
            $sql = "SELECT * FROM treasurer WHERE idTreasurer = :idTreasurer";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idTreasurer", $idTreasurer);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
        }    
    }

    public function searchAll(){
        try {
            $sql = "SELECT * FROM treasurer WHERE 1=1 ".$this->sqlWhere;
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
 
            foreach ($list as $row)
                $f_list[] = $this->showObject($row);
 
            return $f_list;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
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