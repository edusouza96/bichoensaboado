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
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
        
    }

    public function reportClientAttendedByDistrict(){
        try {
            $sql = "
                SELECT COUNT(*) as column1Report, a.district as column2Report
                FROM diary d 
                INNER JOIN client c ON (c.idClient = d.client_idClient) 
                INNER JOIN address a ON (a.idAddress = c.address_idAddress) 
                WHERE 1 ".$this->sqlWhere."
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
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
        
    }

    public function reportClientAttendedByBreed(){
        try {
            $sql = "
                SELECT COUNT(*) as column1Report, b.nameBreed as column2Report
                FROM diary d 
                INNER JOIN client c ON (c.idClient = d.client_idClient) 
                INNER JOIN breed b ON (b.idBreed = c.breed_idBreed) 
                WHERE 1 ".$this->sqlWhere."
                GROUP BY b.idBreed
                ORDER BY b.nameBreed;
            ";
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

    public function reportFinancialByInOut(){
        try {
            $sql = "
                SELECT 
                    SUM(valueInCash) as column1Report,
                    SUM(valueInCredit) as column2Report, 
                    SUM(valueOut) as column3Report,
                    ((SUM(valueInCredit)+SUM(valueInCash)) - SUM(valueOut)) as column4Report,
                    CONCAT(MAX(SUBSTRING(day, 6, 2)),'/',MAX(SUBSTRING(day, 1, 4))) as column5Report
                FROM ( 
                    (SELECT datePayFinancial as day, (valueProduct) AS valueInCash, 0 as valueOut, 0 AS valueInCredit FROM financial WHERE registerBuy IS NOT NULL AND methodPayment = 1)
                    UNION 
                    (SELECT datePayFinancial as day, 0 as valueInCash, (valueProduct) AS valueOut, 0 AS valueInCredit FROM financial WHERE registerBuy IS NULL) 
                    UNION
                    (SELECT datePayFinancial as day, 0 AS valueInCash, 0 as valueOut, (valueProduct) AS valueInCredit FROM financial WHERE registerBuy IS NOT NULL AND methodPayment <> 1)
                ) AS tbl 
                WHERE 1 ".$this->sqlWhere."
                GROUP BY SUBSTRING(day, 1, 7);
            ";
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

    public function reportFinancialByExpenses(){
        try {
            $sql = "
                SELECT f.description AS column1Report, f.valueProduct AS column2Report, cef.descCategoryExpenseFinancial AS column3Report, f.datePayFinancial AS column4Report, cef.idCategoryExpenseFinancial AS column5Report
                FROM financial f
                INNER JOIN category_expense_financial cef ON (cef.idCategoryExpenseFinancial = f.categoryExpenseFinancial)
                WHERE f.sales_idSales IS NULL ".$this->sqlWhere."
                ORDER BY f.datePayFinancial;
            ";
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

    public function reportFinancialBySales(){
        try {
            $sql = "
                SELECT 
                    f.description AS column1Report, 
                    f.valueProduct AS column2Report, 
                    f.datePayFinancial AS column3Report, 
                    IFNULL(p.nameProduct, CONCAT(sp.nameServic, ' - ', b.nameBreed))  AS column4Report,
                    s.quantityProductSales AS column5Report
                FROM financial f
                INNER JOIN sales s ON (s.idSales = f.sales_idSales)
                LEFT JOIN product p ON (p.barcodeProduct = s.product_idProduct)
                LEFT JOIN diary d ON (d.idDiary = s.diary_idDiary)
                LEFT JOIN servic sp ON (sp.idServic = d.servic_idServic)
                LEFT JOIN breed b ON (b.idBreed = sp.breed_idBreed)
                WHERE f.sales_idSales > 0  ".$this->sqlWhere."
                ORDER BY f.datePayFinancial
            ";
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
        
        $reportClass = new ReportClass();
        foreach($row as $field => $value){
            $reportClass->${'field'} = $value;    
        }
       
        return $reportClass;
    }
}
?>