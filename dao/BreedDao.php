<?php
class BreedDAO {
   
      public static $instance;
   
      public function __construct() {
          $path = $_SERVER['DOCUMENT_ROOT']; 
          include_once($path."/bichoensaboado/class/Conexao.php");  
          include_once($path."/bichoensaboado/class/BreedClass.php");
      }
   
      public static function getInstance() {
          if (!isset(self::$instance))
              self::$instance = new BreedDAO();
   
          return self::$instance;
      }
   
      public function Insert(BreedClass $breed) {
          try {
              $sql = "INSERT INTO breed (    
                nameBreed
                )VALUES (
                :nameBreed)";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":nameBreed",  $breed->nameBreed);
              $p_sql->execute();
              return Conexao::getInstance()->lastInsertId();
          } catch (Exception $e) {
              print $e."Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
     
      public function Update(BreedClass $breed) {
          try {
              $sql = "UPDATE breed set
                        nameBreed  = :nameBreed
                    WHERE idBreed = :idBreed";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":idBreed",  $breed->idBreed);
              $p_sql->bindValue(":nameBreed",$breed->nameBreed);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
      
      public function Delete($idBreed) {
          try {
              $sql = "DELETE FROM breed WHERE idBreed = :idBreed";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idBreed", $idBreed);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aУЇУЃo, tente novamente mais tarde.";
          }
      }
   
      
   
      public function SearchId($idBreed) {
          try {
              $sql = "SELECT * FROM breed WHERE idBreed = :idBreed";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idBreed", $idBreed);
              $p_sql->execute();
              return $this->ShowObject($p_sql->fetch(PDO::FETCH_ASSOC));
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aУЇУЃo, tente novamente mais tarde.";
          }
      }
   
     
      public function SearchAll() {
          try {
              $sql = "SELECT * FROM breed order by nameBreed";
              $result = Conexao::getInstance()->query($sql);
              $list = $result->fetchAll(PDO::FETCH_ASSOC);
              $f_list = array();
   
              foreach ($list as $row)
                  $f_list[] = $this->ShowObject($row);
   
              return $f_list;
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aУЇУЃo, tente novamente mais tarde.";
          }
      }
   
     
      private function ShowObject($row) {
          
          $breed = new BreedClass();
          $breed->BreedClass($row['idBreed'], $row['nameBreed']);
          return $breed;
      }
   
  }
  ?>