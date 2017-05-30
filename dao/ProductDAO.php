<?php
class ProductDAO {
   
      public static $instance;
      private $sqlWhere = "";
   
      public function __construct() {
          $path = $_SERVER['DOCUMENT_ROOT']; 
          include_once($path."/bichoensaboado/class/Conexao.php");  
          include_once($path."/bichoensaboado/class/ProductClass.php");
      }
   
      public static function getInstance() {
          if (!isset(self::$instance))
              self::$instance = new ProductDAO();
   
          return self::$instance;
      }
   
      public function insert(ProductClass $product) {
          try {
              $sql = "INSERT INTO product (    
                nameProduct,
                valuationProduct,
                quantityProduct
                )VALUES (
                :nameProduct,
                :valuationProduct,
                :quantityProduct)";
   
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":nameProduct",     $product->nameProduct);
              $p_sql->bindValue(":valuationProduct", $product->valuationProduct);
              $p_sql->bindValue(":quantityProduct", $product->quantityProduct);
              $p_sql->execute();
              $newIdProduct = Conexao::getInstance()->lastInsertId();
              while(strlen ($newIdProduct) < 4){
                $newIdProduct = "0".$newIdProduct;
              }
              $newNameProduct = $newIdProduct."# ".$product->nameProduct;
              $prod = new ProductClass();
              $prod->idProduct = $newIdProduct;
              $prod->nameProduct = $newNameProduct;
              return $this->update($prod);
          } catch (Exception $e) {
              print $e."Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
          }
      }
     
      public function update(ProductClass $product) {
          try {
              
              $sql = "UPDATE product set idProduct = :idProduct";
              $productList = $product->iterateVisible();
              foreach($productList as $key => $value){
                if($value != ""){
                    $sql .= ", ".$key." = '".$value."'";
                }
              }
              $sql .= " WHERE idProduct = :idProduct";
             
              $p_sql = Conexao::getInstance()->prepare($sql);
   
              $p_sql->bindValue(":idProduct",  $product->idProduct);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
          }
      }
      
      public function delete($idProduct) {
          try {
              $sql = "DELETE FROM product WHERE idProduct = :idProduct";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idProduct", $idProduct);
   
              return $p_sql->execute();
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
          }
      }
      
      public function addWhere($value){
        $this->sqlWhere .= 'AND '.$value;
      }

      public function searchId($idProduct) {
          try {
              $sql = "SELECT * FROM product WHERE idProduct = :idProduct";
              $p_sql = Conexao::getInstance()->prepare($sql);
              $p_sql->bindValue(":idProduct", $idProduct);
              $p_sql->execute();
              return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
          } catch (Exception $e) {
              print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
          }
      }
     
      public function searchAll() {
          try {
              $sql = "SELECT * FROM product WHERE 1=1 ".$this->sqlWhere;
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
   
     
      private function showObject($row) {
          
          $product = new ProductClass();
          $product->ProductClass($row['idProduct'], $row['nameProduct'], $row['valuationProduct'], $row['quantityProduct']);
          return $product;
      }
   
  }
  ?>