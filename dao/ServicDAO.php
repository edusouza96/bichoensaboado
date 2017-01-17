<?php
class ServicDAO {
   
      public static $instance;
   
      public function __construct() {
          $path = $_SERVER['DOCUMENT_ROOT']; 
          include_once($path."/bichoensaboado/class/Conexao.php");  
          include_once($path."/bichoensaboado/class/ServicClass.php");
          include_once($path."/bichoensaboado/dao/BreedDAO.php");
      }
   
      public static function getInstance() {
          if (!isset(self::$instance))
              self::$instance = new ServicDAO();
   
          return self::$instance;
      }
     
      public function InsertDefaultBreed($idBreed) {
          try {
              $sql = "INSERT INTO servic (nameServic,breed_idBreed,sizeAnimal,valuation,package)
                VALUES 
                ('Banho', :breed_idBreed, 0, 20, 0),
                ('Banho+Higienica', :breed_idBreed, 0, 30, 0),
                ('Banho+Tosa', :breed_idBreed, 0, 40, 0),
                ('Pacote 15', :breed_idBreed, 0, 100, 1),
                ('Pacote 30', :breed_idBreed, 0, 150, 2);";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":breed_idBreed",    $idBreed);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }

      public function Insert(ServicClass $servic) {
          try {
              $sql = "INSERT INTO servic (    
                nameServic,
                breed_idBreed,
                sizeAnimal,
                valuation,
                package
                )VALUES (
                :nameServic,
                :breed_idBreed,
                :sizeAnimal,
                :valuation,
                :package)";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":nameServic",  $servic->nameServic);
              $p_sql->bindValue(":breed_idBreed",    $servic->breed);
              $p_sql->bindValue(":sizeAnimal",    $servic->sizeAnimal);
              $p_sql->bindValue(":valuation", $servic->valuation);
              $p_sql->bindValue(":package", $servic->package);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
   
      public function Update(ServicClass $servic) {
          try {
              $sql = "UPDATE servic set
                        nameServic    = :nameServic,
                        breed_idBreed = :breed_idBreed,
                        valuation     = :valuation,
                        package       = :package
                    WHERE idServic = :idServic";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idServic", $servic->idServic);
              $p_sql->bindValue(":nameServic",  $servic->nameServic);
              $p_sql->bindValue(":breed_idBreed",    $servic->breed);
              $p_sql->bindValue(":valuation", $servic->valuation);
              $p_sql->bindValue(":package", $servic->package);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
      
      public function Delete($idServic) {
          try {
              $sql = "DELETE FROM servic WHERE idServic = :idServic";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idServic", $idServic);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
   
      public function SearchByName($name) {
          try {
              $sql = "SELECT * FROM servic LEFT JOIN breed ON(breed.idBreed = servic.breed_idBreed) WHERE nameServic LIKE :name OR nameBreed LIKE :name";
              $p_sql = Conexao::getInstance()->prepare($sql);   
              $name = '%'.$name.'%';           
              $p_sql->bindParam(':name', $name, PDO::PARAM_STR);
              $p_sql->execute();
              $list = $p_sql->fetchAll(PDO::FETCH_ASSOC);
              $f_list = array();
   
              foreach ($list as $row)
                  $f_list[] = $this->ShowObject($row);
   
              return $f_list;
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
   
      public function SearchId($idServic) {
          try {
              $sql = "SELECT * FROM servic WHERE idServic = :idServic";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idServic", $idServic);
              $p_sql->execute();
              return $this->ShowObject($p_sql->fetch(PDO::FETCH_ASSOC));
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
   
      public function SearchBreed($idBreed) {
          try {
              $sql = "SELECT * FROM servic WHERE breed_idBreed = :idBreed";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idBreed", $idBreed);
              $p_sql->execute();
              $list = $p_sql->fetchAll(PDO::FETCH_ASSOC);
              $f_list = array();
   
              foreach ($list as $row)
                  $f_list[] = $this->ShowObject($row);
   
              return $f_list;
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
     
      public function SearchAll() {
          try {
              $sql = "SELECT * FROM servic order by idServic";
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
        $servic = new ServicClass();
        $servic->idServic = $row['idServic'];
        $servic->nameServic = $row['nameServic'];
        $servic->breed = BreedDAO::getInstance()->SearchId($row['breed_idBreed']);
        $servic->sizeAnimal = $row['sizeAnimal'];
        $servic->valuation =$row['valuation'];
        $servic->package =$row['package'];
        return $servic;
      }
   
  }
  ?>