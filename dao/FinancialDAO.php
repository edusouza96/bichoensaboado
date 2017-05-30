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
                userFinancial,
                product,
                valuePrduct,
                description
                )VALUES (
                :registerBuy,
                :userFinancial,
                :product,
                :valuePrduct,
                :description)";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":registerBuy",  $financial->registerBuy);
              $p_sql->bindValue(":userFinancial",$financial->userFinancial);
              $p_sql->bindValue(":product",      $financial->product);
              $p_sql->bindValue(":valuePrduct",  $financial->valuePrduct);
              $p_sql->bindValue(":description",  $financial->description);
              $p_sql->execute();
              return Conexao::getInstance()->lastInsertId();
          } catch (Exception $e) {
              print $e."Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
     
      public function update(FinancialClass $financial) {
          try {
              $sql = "UPDATE financial set idFinancial = :idFinancial";
              foreach($financial as $key => $value){
                if($value != ""){
                    $sql .= ", ".$key." = ".$value;
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
      
      public function delete($registerBuy) {
          try {
              $sql = "DELETE FROM financial WHERE registerBuy = :registerBuy";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":registerBuy", $registerBuy);
   
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
          $financial->FinancialClass($row['idFinancial'], $row['nameFinancial']);
          return $financial;
      }
   
  }
  ?>