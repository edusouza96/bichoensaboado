<?php
class FinancialDAO {
   
      public static $instance;
      private static $sqlWhere;
   
      public function __construct() {
          $path = $_SERVER['DOCUMENT_ROOT']; 
          include_once($path."/bichoensaboado/class/Conexao.php");  
          include_once($path."/bichoensaboado/class/FinancialClass.php");
      }
   
      public static function getInstance() {
          if (!isset(self::$instance))
              self::$instance = new FinancialDAO();
   
          return self::$instance;
      }
   
      public function insert(FinancialClass $financial) {
          try {
              $sql = "INSERT INTO financial (    
                registerBuy,
                sales_idSales,
                valueProduct,
                description,
                dateDueFinancial,
                datePayFinancial
                )VALUES (
                :registerBuy,
                :sales,
                :valueProduct,
                :description,
                :dateDueFinancial,
                :datePayFinancial)";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":registerBuy",      $financial->registerBuy);
              $p_sql->bindValue(":sales",            $financial->sales);
              $p_sql->bindValue(":valueProduct",      $financial->valueProduct);
              $p_sql->bindValue(":description",      $financial->description);
              $p_sql->bindValue(":dateDueFinancial", $financial->dateDueFinancial);
              $p_sql->bindValue(":datePayFinancial", $financial->datePayFinancial);
              $p_sql->execute();
              return Conexao::getInstance()->lastInsertId();
          } catch (Exception $e) {
              print $e."Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
     
      public function update(FinancialClass $financial) {
          try {
              $sql = "UPDATE financial set idFinancial = :idFinancial";
              $financialList = $financial->iterateVisible();
              foreach($financialList as $key => $value){
                if($value != ""){
                    $sql .= ", ".$key." = '".$value."'";
                }
              }
              $sql .= " WHERE idFinancial = :idFinancial";

              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":idFinancial",  $financial->idFinancial);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
      
      public function delete($idFinancial) {
          try {
              $sql = "DELETE FROM financial WHERE idFinancial = :idFinancial";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idFinancial", $idFinancial);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
      
      public function addWhere($value){
        $this->sqlWhere .= 'AND '.$value;
      }

      public function searchId($idFinancial) {
          try {
              $sql = "SELECT * FROM financial WHERE idFinancial = :idFinancial";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idFinancial", $idFinancial);
              $p_sql->execute();
              return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
     
      public function searchAll() {
          try {
              $sql = "SELECT * FROM financial WHERE 1=1 ".$this->sqlWhere;
              $result = Conexao::getInstance()->query($sql);
              $list = $result->fetchAll(PDO::FETCH_ASSOC);
              $f_list = array();
   
              foreach ($list as $row)
                  $f_list[] = $this->showObject($row);
   
              return $f_list;
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуoo, tente novamente mais tarde.";
          }
      }
   
     
      private function showObject($row) {
          
          $financial = new FinancialClass();
          $financial->idFinancial       = $row['idFinancial'];
          $financial->description       = $row['description'];
          $financial->dateDueFinancial  = $row['dateDueFinancial'];
          $financial->datePayFinancial  = $row['datePayFinancial'];
          $financial->valueProduct      = $row['valueProduct'];
          $financial->registerBuy       = $row['registerBuy'];
          $financial->sales             = $row['sales_idSales'];
          return $financial;
      }
   
  }
  ?>