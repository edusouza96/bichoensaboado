<?php
class DiaryDAO {
   
      public static $instance;
   
      public function __construct() {
          include_once("../class/Conexao.php");
          include_once("../class/DiaryClass.php");
          include_once("../dao/ClientDAO.php");
          include_once("../dao/ServicDAO.php");
      }
   
      public static function getInstance() {
          if (!isset(self::$instance))
              self::$instance = new DiaryDAO();
   
          return self::$instance;
      }
   
      public function Insert(DiaryClass $diary) {
          try {
              $sql = "INSERT INTO diary (    
                  client_idClient,
                  servic_idServic,
                  search,
                  price,
                  deliveryPrice,
                  totalPrice,
                  dateHour)
                  VALUES (
                  :client_idClient,
                  :servic_idServic,
                  :search,
                  :price,
                  :deliveryPrice,
                  :totalPrice,
                  :dateHour)";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
//              $p_sql->bindValue(":client_idClient", $diary->client->idClient);
//              $p_sql->bindValue(":servic_idServic", $diary->servic->idServic);
              $p_sql->bindValue(":client_idClient", $diary->client_idClient);
              $p_sql->bindValue(":servic_idServic", $diary->servic_idServic);
              $p_sql->bindValue(":search",          $diary->search);
              $p_sql->bindValue(":price",           $diary->price);
              $p_sql->bindValue(":deliveryPrice",   $diary->deliveryPrice);
              $p_sql->bindValue(":totalPrice",      $diary->totalPrice);
              $p_sql->bindValue(":dateHour",        $diary->dateHour);
   
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
          }
      }
   
      public function Update(DiaryClass $diary) {
          try {
              $sql = "UPDATE diary set
                        client_idClient = :client_idClient,
                        servic_idServic = :servic_idServic,
                        search          = :search,
                        price           = :price,
                        deliveryPrice   = :deliveryPrice,
                        totalPrice      = :totalPrice,
                        dateHour        = :dateHour
                    WHERE idDiary = :idDiary";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":client_idClient", $diary->client_idClient);
              $p_sql->bindValue(":servic_idServic", $diary->servic_idServic);
              $p_sql->bindValue(":search",          $diary->search);
              $p_sql->bindValue(":price",           $diary->price);
              $p_sql->bindValue(":deliveryPrice",   $diary->deliveryPrice);
              $p_sql->bindValue(":totalPrice",      $diary->totalPrice);
              $p_sql->bindValue(":dateHour",        $diary->dateHour);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
          }
      }
      
      public function Delete($idDiary) {
          try {
              $sql = "DELETE FROM diary WHERE idDiary = :idDiary";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idDiary", $idDiary);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
          }
      }
   
      
   
      public function SearchId($idDiary) {
          try {
              $sql = "SELECT * FROM diary WHERE idDiary = :idDiary";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idDiary", $idDiary);
              $p_sql->execute();
              return $this->ShowObject($p_sql->fetch(PDO::FETCH_ASSOC));
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
          }
      }
   
     
      public function SearchAll() {
          try {
              $sql = "SELECT * FROM diary order by dateHour";
              $result = Conexao::getInstance()->query($sql);
              $list = $result->fetchAll(PDO::FETCH_ASSOC);
              $f_list = array();
   
              foreach ($list as $row)
                  $f_list[] = $this->ShowObject($row);
   
              return $f_list;
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
          }
      }
   
     public function SearchDate($dateHour) {
          try {
              $sql = "SELECT * FROM diary WHERE (SELECT SUBSTRING(dateHour, 1, 10 )) = :dateHour ";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":dateHour", $dateHour);
              $p_sql->execute();
              $list = $p_sql->fetchAll(PDO::FETCH_ASSOC);
              $f_list = array();
   
              foreach ($list as $row)
                  $f_list[] = $this->ShowObject($row);
   
              return $f_list;

          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
          }
      }

      public function SearchDateHour($dateHour) {
          try {
              $sql = "SELECT * FROM diary WHERE dateHour = :dateHour ";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":dateHour", $dateHour);
              $p_sql->execute();
              $list = $p_sql->fetchAll(PDO::FETCH_ASSOC);
              $f_list = array();
   
              foreach ($list as $row)
                  $f_list[] = $this->ShowObject($row);
   
              return $f_list;

          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
          }
      }

     private function ShowObject($row) {
          
          $diary = new DiaryClass();
          $diary->idDiary         = ($row['idDiary']);
          $diary->client          = ClientDAO::getInstance()->SearchId($row['client_idClient']);
          $diary->servic          = ServicDAO::getInstance()->SearchId($row['servic_idServic']);
          $diary->search          = ($row['search']);
          $diary->price           = ($row['price']);
          $diary->deliveryPrice   = ($row['deliveryPrice']);
          $diary->totalPrice      = ($row['totalPrice']);
          $diary->dateHour        = ($row['dateHour']);
          return $diary;
      }
   
  }
?>

