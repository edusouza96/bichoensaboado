<?php
class ReportDAO{
    public static $instance;
    private $sqlWhere = "";

    public function __construct() {
        $path = $_SERVER['DOCUMENT_ROOT']; 
        include_once($path."/bichoensaboado/class/Conexao.php");  
        include_once($path."/bichoensaboado/class/ReportClass.php");
    }

    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new ReportDAO();
 
        return self::$instance;
    }

    public function addWhere($value){
        $this->sqlWhere .= 'AND '.$value;
    }

    public function reportSearchDoneByDistrict(){
        try {
            $sql = "
                SELECT COUNT(*) as column1Report, a.district as column2Report, SUM(a.valuation) as column3Report 
                FROM diary d 
                INNER JOIN client c ON (c.idClient = d.client_idClient) 
                INNER JOIN address a ON (a.idAddress = c.address_idAddress) 
                WHERE search = 1 ".$this->sqlWhere."
                GROUP BY a.idAddress
                ORDER BY a.district;
            ";
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
            foreach ($list as $row)
                $f_list[] = $this->showObject($row);

            return $f_list;
            
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
        }
        
    }

    public function reportClientAttendedByDistrict(){
        try {
            $sql = "
                SELECT COUNT(*) as column1Report, a.district as column2Report
                FROM diary d 
                INNER JOIN client c ON (c.idClient = d.client_idClient) 
                INNER JOIN address a ON (a.idAddress = c.address_idAddress) 
                WHERE 1 
                GROUP BY a.idAddress;
            ";
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
            foreach ($list as $row)
                $f_list[] = $this->showObject($row);

            return $f_list;
            
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
        }
        
    }

    public function reportClientAttendedByBreed(){
        try {
            $sql = "
                SELECT COUNT(*) as column1Report, b.nameBreed as column2Report
                FROM diary d 
                INNER JOIN client c ON (c.idClient = d.client_idClient) 
                INNER JOIN breed b ON (b.idBreed = c.breed_idBreed) 
                WHERE 1
                GROUP BY b.idBreed;
            ";
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
            foreach ($list as $row)
                $f_list[] = $this->showObject($row);

            return $f_list;
            
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
        }
        
    }

    public function reportFinancialByInOut(){
        try {
            $sql = "
                SELECT COUNT(*) as column1Report, IF(f.sales_idSales > 0, 'Entrada', 'Saida') as column2Report
                FROM financial f 
                GROUP BY column2Report;
            ";
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
            foreach ($list as $row)
                $f_list[] = $this->showObject($row);

            return $f_list;
            
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
        }
        
    }

    public function reportFinancialByExpenses(){
        try {
            $sql = "
                SELECT f.description AS column1Report, f.valueProduct AS column2Report, cef.descCategoryExpenseFinancial AS column3Report, f.datePayFinancial AS column4Report
                FROM financial f
                INNER JOIN category_expense_financial cef ON (cef.idCategoryExpenseFinancial = f.categoryExpenseFinancial)
                WHERE f.sales_idSales IS NULL
                ORDER BY f.datePayFinancial;
            ";
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
            foreach ($list as $row)
                $f_list[] = $this->showObject($row);

            return $f_list;
            
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta aчуo, tente novamente mais tarde.";
        }
        
    }

    private function showObject($row) {
        
        $reportClass = new ReportClass();
        foreach($row as $field => $value){
            $reportClass->${'field'} = $value;    
        }
       
        return $reportClass;
    }
}
?>