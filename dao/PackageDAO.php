<?php
class PackageDAO {
   
      public static $instance;
   
      public function __construct() {
          $path = $_SERVER['DOCUMENT_ROOT']; 
          include_once($path."/bichoensaboado/class/Conexao.php");  
          include_once($path."/bichoensaboado/class/PackageClass.php");
      }
   
      public static function getInstance() {
          if (!isset(self::$instance))
              self::$instance = new PackageDAO();
   
          return self::$instance;
      }
   
      public function Insert(PackageClass $package) {
          try {
              $sql = "INSERT INTO package (    
                date1,
                week1,
                date2,
                week2,
                date3,
                week3,
                date4,
                week4
                )VALUES (
                :date1,
                :week1,
                :date2,
                :week2,
                :date3,
                :week3,
                :date4,
                :week4)";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":date1", $package->date1);
              $p_sql->bindValue(":week1", $package->week1);
              $p_sql->bindValue(":date2", $package->date2);
              $p_sql->bindValue(":week2", $package->week2);
              $p_sql->bindValue(":date3", $package->date3);
              $p_sql->bindValue(":week3", $package->week3);
              $p_sql->bindValue(":date4", $package->date4);
              $p_sql->bindValue(":week4", $package->week4);
   
   
              $p_sql->execute();
              return Conexao::getInstance()->lastInsertId();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
   
      public function Update(PackageClass $package) {
          try {
              $sql = "UPDATE package set
                        date1 = :date1,
                        week1 = :week1,
                        date2 = :date2,
                        week2 = :week2,
                        date3 = :date3,
                        week3 = :week3
                        date4 = :date4,
                        week4 = :week4
                    WHERE idPackage = :idPackage";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":idPackage", $Package->idPackage);
              $p_sql->bindValue(":date1", $Package->date1);
              $p_sql->bindValue(":week1", $Package->week1);
              $p_sql->bindValue(":date2", $Package->date2);
              $p_sql->bindValue(":week2", $Package->week2);
              $p_sql->bindValue(":date3", $Package->date3);
              $p_sql->bindValue(":week3", $Package->week3);
              $p_sql->bindValue(":date4", $Package->date4);
              $p_sql->bindValue(":week4", $Package->week4);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
      
      public function Delete($idPackage) {
          try {
              $sql = "DELETE FROM package WHERE idPackage = :idPackage";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idPackage", $idPackage);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
   
      
   
      public function SearchId($idPackage) {
          try {
              $sql = "SELECT * FROM package WHERE idPackage = :idPackage";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idPackage", $idPackage);
              $p_sql->execute();
              return $this->ShowObject($p_sql->fetch(PDO::FETCH_ASSOC));
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
   
     
      public function SearchAll() {
          try {
              $sql = "SELECT * FROM package order by idPackage";
              $result = Conexao::getInstance()->query($sql);
              $list = $result->fetchAll(PDO::FETCH_ASSOC);
              $f_list = array();
   
              foreach ($list as $row)
                  $f_list[] = $this->ShowObject($row);
   
              return $f_list;
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
   
     
      private function ShowObject($row) {
          
         $package = new PackageClass();
         $package->idPackage = $row['idPackage'];
         $package->date1 = $row['date1'];
         $package->week1 = $row['week1'];
         $package->date2 = $row['date2'];
         $package->week2 = $row['week2'];
         $package->date3 = $row['date3'];
         $package->week3 = $row['week3'];
         $package->date4 = $row['date4'];
         $package->week4 = $row['week4'];
         return $package;
      }
   
  }
  ?>