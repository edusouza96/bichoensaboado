<?php
class SalesDAO{
   
    public static $instance;
    private $sqlWhere;
   
    public function __construct() {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include_once($path."/bichoensaboado/class/Conexao.php");
        include_once($path."/bichoensaboado/class/SalesClass.php");
    }
   
    public static function getInstance(){
        if (!isset(self::$instance)) {
            self::$instance = new SalesDAO();
        }
   
        return self::$instance;
    }
   
    public function insert(SalesClass $sales){
        try {
            $sql = "INSERT INTO sales (    
                diary_idDiary,
                product_idProduct,
                quantityProductSales,
                valuationUnitSales 
                )VALUES (
                :diarySales,
                :productSales,
                :quantityProductSales,
                :valuationUnitSales)";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":diarySales", $sales->diarySales);
            $p_sql->bindValue(":productSales", $sales->productSales);
            $p_sql->bindValue(":quantityProductSales", $sales->quantityProductSales);
            $p_sql->bindValue(":valuationUnitSales", $sales->valuationUnitSales);
            $p_sql->execute();
            return Conexao::getInstance()->lastInsertId();
        } catch (Exception $e) {
            print $e."Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function update(SalesClass $sales){
        try {
            $sql = "UPDATE sales set idSales = :idSales";
            foreach ($sales as $key => $value) {
                if ($value != "") {
                    $sql .= ", ".$key." = ".$value;
                }
            }
            $sql .= " WHERE idSales = :idSales";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":idSales", $sales->idSales);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
      
    public function delete($diarySales){
        try {
            $sql = "DELETE FROM sales WHERE idSales = :idSales";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idSales", $idSales);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
      
    public function addWhere($value){
        $this->sqlWhere .= 'AND '.$value;
    }

    public function searchId($idSales){
        try {
            $sql = "SELECT * FROM sales WHERE idSales = :idSales";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idSales", $idSales);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function searchAll(){
        try {
            $sql = "SELECT * FROM sales WHERE 1=1 ".$this->sqlWhere;
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
   
            foreach ($list as $row) {
                $f_list[] = $this->showObject($row);
            }
   
            return $f_list;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta açãoo, tente novamente mais tarde.";
        }
    }
   
     
    private function showObject($row){
        $sales = new SalesClass();
        $sales->SalesClass($row['idSales'], $row['diary_idDiary'], $row['product_idProduct'], $row['quantityProductSales'], $row['valuationUnitSales']);
        return $sales;
    }
}
