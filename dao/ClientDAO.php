<?php
class ClientDAO {
   
      public static $instance;
   
      public function __construct() {
          $path = $_SERVER['DOCUMENT_ROOT']; 
          include_once($path."/bichoensaboado/class/Conexao.php");  
          include_once($path."/bichoensaboado/class/ClientClass.php");
          include_once($path."/bichoensaboado/dao/AddressDAO.php");
          include_once($path."/bichoensaboado/dao/BreedDAO.php");
      }
   
      public static function getInstance() {
          if (!isset(self::$instance))
              self::$instance = new ClientDAO();
   
          return self::$instance;
      }
   
      public function Insert(ClientClass $client) {
          try {
              $sql = "INSERT INTO client (    
                owner,
                idOwner,
                nameAnimal,
                breed_idBreed,
                address_idAddress,
                addressNumber,
                addressComplement,
                phone1,
                phone2,
                email
                )VALUES (
                :owner,
                :idOwner,
                :nameAnimal,
                :breed_idBreed,
                :address_idAddress,
                :addressNumber,
                :addressComplement,
                :phone1,
                :phone2,
                :email)";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              if($client->idOwner == 0){
                  $client->idOwner = $this->UltimateOwner();
              }
              $p_sql->bindValue(":owner",             $client->owner);
              $p_sql->bindValue(":idOwner",           $client->idOwner);
              $p_sql->bindValue(":nameAnimal",        $client->nameAnimal);
              $p_sql->bindValue(":breed_idBreed",     $client->breed);
              $p_sql->bindValue(":address_idAddress", $client->address);
              $p_sql->bindValue(":addressNumber",     $client->addressNumber);
              $p_sql->bindValue(":addressComplement", $client->addressComplement);
              $p_sql->bindValue(":phone1",            $client->phone1);
              $p_sql->bindValue(":phone2",            $client->phone2);
              $p_sql->bindValue(":email",             $client->email);
   
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print $e;///"Ocorreu um erro ao tentar executar esta aчуo tente novamente mais tarde.";
          }
      }
   
      public function Update(clientClass $client) {
          try {
              $sql = "UPDATE client set
                        owner             = :owner,
                        nameAnimal        = :nameAnimal,
                        breed_idBreed     = :breed_idBreed,
                        address_idAddress = :address_idAddress,
                        addressNumber     = :addressNumber,
                        addressComplement = :addressComplement,
                        phone1            = :phone1,
                        phone2            = :phone2,
                        email             = :email
                    WHERE idClient = :idClient";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":idClient",          $client->idClient);
              $p_sql->bindValue(":owner",             $client->owner);
              $p_sql->bindValue(":nameAnimal",        $client->nameAnimal);
              $p_sql->bindValue(":breed_idBreed",     $client->breed);
              $p_sql->bindValue(":address_idAddress", $client->address);
              $p_sql->bindValue(":addressNumber",     $client->addressNumber);
              $p_sql->bindValue(":addressComplement", $client->addressComplement);
              $p_sql->bindValue(":phone1",            $client->phone1);
              $p_sql->bindValue(":phone2",            $client->phone2);
              $p_sql->bindValue(":email",             $client->email);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
      
      public function Delete($idClient) {
          try {
              $sql = "DELETE FROM client WHERE idClient = :idClient";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idClient", $idClient);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
   
      
   
      public function SearchId($idClient) {
          try {
              $sql = "SELECT * FROM client WHERE idClient = :idClient";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idClient", $idClient);
              $p_sql->execute();
              return $this->ShowObject($p_sql->fetch(PDO::FETCH_ASSOC));
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }

      private function UltimateOwner() {
          try {
              $sql = "SELECT MAX(idOwner+1) AS idOwner FROM client ";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->execute();
              $result = ($p_sql->fetch(PDO::FETCH_ASSOC));
              return $result['idOwner'];
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }

      public function SearchAnimalsSameOwner($idClient) {
          try {
              $sql = "SELECT * FROM client WHERE idOwner = (SELECT idOwner FROM client WHERE idClient = :idClient)";
              $p_sql = Conexao::getInstance()->prepare($sql);              
              $p_sql->bindValue(":idClient", $idClient);
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
   
      public function SearchAnimalsSameOwnerByIdOwner($idOwner) {
          try {
              $sql = "SELECT * FROM client WHERE idOwner = :idOwner";
              $p_sql = Conexao::getInstance()->prepare($sql);              
              $p_sql->bindValue(":idOwner", $idOwner);
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

      public function SearchName() {
          try {
              $sql = "SELECT * FROM client GROUP BY nameAnimal";
              $result = Conexao::getInstance()->prepare($sql);
              $result->execute();
              $list = $result->fetchAll(PDO::FETCH_ASSOC);
              $f_list = array();
              foreach ($list as $row){
                  $obj = $this->ShowObject($row);
                  
                  $f_list[] = array('label' => utf8_encode($obj->nameAnimal));
              }
              return $f_list;
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }

      public function SearchOwner($nameAnimal) {
          try {
              $sql = "SELECT * FROM client WHERE nameAnimal = :nameAnimal ";
              $p_sql = Conexao::getInstance()->prepare($sql);              
              $p_sql->bindValue(":nameAnimal", $nameAnimal);
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

      public function SearchByName($name) {
          try {
              $sql = "SELECT * FROM client WHERE nameAnimal LIKE :name OR  owner LIKE :name ";
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

      public function SearchAll() {
          try {
              $sql = "SELECT * FROM client order by nameAnimal";
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
          
          $client = new ClientClass();
          $client->idClient          = ($row['idClient']);
          $client->owner             = ($row['owner']);
          $client->idOwner           = ($row['idOwner']);
          $client->nameAnimal        = ($row['nameAnimal']);
          $client->breed             = BreedDAO::getInstance()->SearchId($row['breed_idBreed']);
          $client->address           = AddressDAO::getInstance()->SearchId($row['address_idAddress']);
          $client->addressNumber     = ($row['addressNumber']);
          $client->addressComplement = ($row['addressComplement']);
          $client->phone1            = ($row['phone1']);
          $client->phone2            = ($row['phone2']);
          $client->email             = ($row['email']);

          return $client;
      }
   
      
      public function ScriptAnimalsSameOwner() {
          try {
              $sql = "SELECT GROUP_CONCAT( CAST( idClient AS CHAR ) SEPARATOR  '|') FROM  `client` GROUP BY addressNumber, owner, address_idAddress";
              $result = Conexao::getInstance()->query($sql);
              $list = $result->fetchAll(PDO::FETCH_ASSOC);
              
              return $list;
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
        
      public function UpdateIdOwner($idOwner, $idClient) {
          try {
              $sql = "UPDATE client set idOwner = :idOwner WHERE idClient = :idClient";
              $p_sql = Conexao::getInstance()->prepare($sql);
    
              $p_sql->bindValue(":idOwner",          $idOwner);
              $p_sql->bindValue(":idClient",  $idClient);
        
              return $p_sql->execute();
          } catch (Exception $e) {
              print $e;///"Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
          }
      }
  }
     
  ?>