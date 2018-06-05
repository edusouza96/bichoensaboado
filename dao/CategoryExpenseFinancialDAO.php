<?php
class CategoryExpenseFinancialDAO
{
   
    public static $instance;
    private $sqlWhere = "";
   
    public function __construct()
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include_once($path."/bichoensaboado/class/Conexao.php");
        include_once($path."/bichoensaboado/class/CategoryExpenseFinancialClass.php");
    }
   
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new CategoryExpenseFinancialDAO();
        }
   
        return self::$instance;
    }
   
    public function insert(CategoryExpenseFinancialClass $categoryExpenseFinancial)
    {
        try {
            $sql = "INSERT INTO category_expense_financial (    
                descCategoryExpenseFinancial
                )VALUES (
                :descCategoryExpenseFinancial)";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":descCategoryExpenseFinancial", $categoryExpenseFinancial->descCategoryExpenseFinancial);
            $p_sql->execute();
            return Conexao::getInstance()->lastInsertId();
        } catch (Exception $e) {
            print $e."Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function update(CategoryExpenseFinancialClass $categoryExpenseFinancial)
    {
        try {
            $sql = "UPDATE category_expense_financial set idCategoryExpenseFinancial = :idCategoryExpenseFinancial";
            $CategoryExpenseFinancialList = $CategoryExpenseFinancial->iterateVisible();
            foreach ($CategoryExpenseFinancialList as $key => $value) {
                if ($value != "") {
                    $sql .= ", ".$key." = '".$value."'";
                }
            }
            $sql .= " WHERE idCategoryExpenseFinancial = :idCategoryExpenseFinancial";
             
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":idCategoryExpenseFinancial", $categoryExpenseFinancial->idCategoryExpenseFinancial);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
      
    public function delete($idCategoryExpenseFinancial)
    {
        try {
            $sql = "DELETE FROM category_expense_financial WHERE idCategoryExpenseFinancial = :idCategoryExpenseFinancial";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idCategoryExpenseFinancial", $idCategoryExpenseFinancial);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
      
    public function addWhere($value)
    {
        $this->sqlWhere .= 'AND '.$value;
    }

    public function searchId($idCategoryExpenseFinancial)
    {
        try {
            $sql = "SELECT * FROM category_expense_financial WHERE idCategoryExpenseFinancial = :idCategoryExpenseFinancial";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idCategoryExpenseFinancial", $idCategoryExpenseFinancial);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function searchAll()
    {
        try {
            $sql = "SELECT * FROM category_expense_financial WHERE 1=1 ".$this->sqlWhere;
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
          
        $categoryExpenseFinancial = new CategoryExpenseFinancialClass();
        $categoryExpenseFinancial->CategoryExpenseFinancialClass(
            $row['idCategoryExpenseFinancial'], 
            $row['descCategoryExpenseFinancial']
        );
        return $categoryExpenseFinancial;
    }
}
