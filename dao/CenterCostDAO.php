<?php
class CenterCostDAO
{
   
    public static $instance;
    private $sqlWhere = "";
   
    public function __construct()
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include_once($path."/bichoensaboado/class/Conexao.php");
        include_once($path."/bichoensaboado/class/CenterCostClass.php");
        include_once($path."/bichoensaboado/dao/CategoryExpenseFinancialDAO.php");
    }
   
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new CenterCostDAO();
        }
   
        return self::$instance;
    }
   
    public function insert(CenterCostClass $centerCost)
    {
        try {
            $sql = "INSERT INTO center_cost (    
                category_expense_financial_idCategoryExpenseFinancial,
                nameCenterCost
                )VALUES (
                :categoryExpenseFinancial,
                :nameCenterCost
                )";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":categoryExpenseFinancial",  $centerCost->categoryExpenseFinancial);
            $p_sql->bindValue(":nameCenterCost",            $centerCost->nameCenterCost);
            $p_sql->execute();
            $newIdCenterCost = Conexao::getInstance()->lastInsertId();
              
            return $newIdCenterCost;
        } catch (Exception $e) {
            print $e."Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function update(CenterCostClass $centerCost)
    {
        try {
            $sql = "UPDATE center_cost set idCenterCost = :idCenterCost";
            $centerCostList = $centerCost->iterateVisible();
            foreach ($centerCostList as $key => $value) {
                if ($value != "") {
                    $sql .= ", ".$key." = '".$value."'";
                }
            }
            $sql .= " WHERE idCenterCost = :idCenterCost ORDER BY category_expense_financial_idCategoryExpenseFinancial, nameCenterCost";
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":idCenterCost", $centerCost->idCenterCost);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

   
    public function delete($idCenterCost)
    {
        try {
            $sql = "DELETE FROM center_cost WHERE idCenterCost = :idCenterCost";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idCenterCost", $idCenterCost);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
      
    public function addWhere($value)
    {
        $this->sqlWhere .= 'AND '.$value;
    }

    public function searchId($idCenterCost)
    {
        try {
            $sql = "SELECT * FROM center_cost WHERE idCenterCost = :idCenterCost";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idCenterCost", $idCenterCost);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function searchAll()
    {
        try {
            $sql = "SELECT * FROM center_cost WHERE 1=1 ".$this->sqlWhere;
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
            
            foreach ($list as $row) {
                $f_list[] = $this->showObject($row);
            }
   
            return $f_list;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
   
     
    private function showObject($row)
    {
        $centerCost = new CenterCostClass();
        $centerCost->idCenterCost = $row['idCenterCost'];
        $centerCost->nameCenterCost = $row['nameCenterCost'];
        $centerCost->categoryExpenseFinancial = CategoryExpenseFinancialDAO::getInstance()->searchId($row['category_expense_financial_idCategoryExpenseFinancial']);
        return $centerCost;
    }
}
