<?php
class ReportDAO{
    public static $instance;
    private $sqlWhere = "";

    public function __construct() {
        $path = $_SERVER['DOCUMENT_ROOT']; 
        include_once($path."/bichoensaboado/class/Conexao.php");  
        include_once($path."/bichoensaboado/class/ReportClass.php");
        include_once($path."/bichoensaboado/class/LoginClass.php");
        include_once $path."/bichoensaboado/view/inc/util.php";
    }

    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new ReportDAO();
 
        return self::$instance;
    }

    public function addWhere($value){
        $this->sqlWhere .= 'AND '.$value;
    }

    public function reportSearchDoneByPeriod(){
        try {
            $sql = "
                SELECT 
                    c.nameAnimal as column1Report,
                    c.owner as column2Report, 
                    a.district as column3Report, 
                    d.dateHour as column4Report, 
                    a.valuation as column5Report, 
                    a.idAddress as column6Report,
                    im.nameMethodPayment as column7Report,
                    im.idMethodPayment as column8Report
                FROM diary d 
                INNER JOIN client c ON (c.idClient = d.client_idClient) 
                INNER JOIN address a ON (a.idAddress = c.address_idAddress) 
                INNER JOIN sales s ON (s.diary_idDiary = d.idDiary)
                INNER JOIN financial f ON (f.sales_idSales = s.idSales)
                INNER JOIN zinfo_method_payment im ON (im.idMethodPayment = f.methodPayment)
                WHERE search = 1 ".$this->sqlWhere." AND f.store = ".getStore()."
                ORDER BY a.district, d.dateHour;
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

    public function reportExpenseWithSearch(){
        try {
            $sql = "
                SELECT f.description as column1Report, f.valueProduct as column2Report, f.datePayFinancial as column3Report
                FROM financial f 
                WHERE f.center_cost_idCenterCost = 7 ".$this->sqlWhere."  AND f.store = ".getStore()."
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

    public function reportClientAttendedByDistrict(){
        try {
            $sql = "
                SELECT COUNT(*) as column1Report, a.district as column2Report
                FROM diary d 
                INNER JOIN client c ON (c.idClient = d.client_idClient) 
                INNER JOIN address a ON (a.idAddress = c.address_idAddress) 
                WHERE 1 ".$this->sqlWhere." AND d.store = ".getStore()."
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
                WHERE 1 ".$this->sqlWhere." AND d.store = ".getStore()."
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
                    (SELECT datePayFinancial as day, SUM(valueProduct) AS valueInCash, 0 as valueOut, 0 AS valueInCredit FROM financial WHERE registerBuy IS NOT NULL AND methodPayment = 1  AND store = ".getStore()." GROUP BY day)
                    UNION
                    (SELECT datePayFinancial as day, 0 AS valueInCash, 0 as valueOut, SUM(valueAliquot) AS valueInCredit FROM financial WHERE registerBuy IS NOT NULL AND methodPayment <> 1  AND store = ".getStore()." GROUP BY day)
                    UNION 
                    (SELECT datePayFinancial as day, 0 as valueInCash, SUM(valueProduct) AS valueOut, 0 AS valueInCredit FROM financial WHERE registerBuy IS NULL  AND store = ".getStore()." GROUP BY day) 
                    
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
                SELECT ct.nameCenterCost AS column1Report, f.valueProduct AS column2Report, cef.descCategoryExpenseFinancial AS column3Report, f.datePayFinancial AS column4Report, cef.idCategoryExpenseFinancial AS column5Report
                FROM financial f
                INNER JOIN center_cost ct ON (ct.idCenterCost = f.center_cost_idCenterCost)
                INNER JOIN category_expense_financial cef ON (cef.idCategoryExpenseFinancial = ct.category_expense_financial_idCategoryExpenseFinancial)
                WHERE f.sales_idSales IS NULL ".$this->sqlWhere." AND f.store = ".getStore()."
                ORDER BY f.datePayFinancial;
            ";
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC); 
            $f_list = array();
            foreach ($list as $row)
                $f_list[] = $this->showObject($row);

            return $f_list;
            
        } catch (Exception $e) {
            print $e."Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
        
    }

    public function reportFinancialBySales(){
        try {
            $sql = "
                SELECT 
                    f.description AS column1Report, 
                    IF(f.methodPayment > 1, f.valueAliquot, f.valueProduct) AS column2Report, 
                    f.datePayFinancial AS column3Report, 
                    IFNULL(p.nameProduct, CONCAT(sp.nameServic, ' - ', IFNULL(b.nameBreed, 'Vet')))  AS column4Report,
                    s.quantityProductSales AS column5Report
                FROM financial f
                INNER JOIN sales s ON (s.idSales = f.sales_idSales)
                LEFT JOIN product p ON (p.barcodeProduct = s.product_idProduct)
                LEFT JOIN diary d ON (d.idDiary = s.diary_idDiary)
                LEFT JOIN servic sp ON (sp.idServic = d.servic_idServic)
                LEFT JOIN breed b ON (b.idBreed = sp.breed_idBreed)
                WHERE f.sales_idSales > 0  ".$this->sqlWhere." AND f.store = ".getStore()."
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

    public function reportSangriaOfDay(){
        try {
            $sql = "
                SELECT 
                    SUM(s.value) AS column1Report
                FROM sangria s 
                WHERE s.store = ".getStore()."
                GROUP BY s.date
                HAVING s.date = CURDATE()
            ";

            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
            
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function reportDayMovement(){
        try {
            $sql = "
                SELECT 
                    SUM(f.valueProduct) AS column1Report, 
                    f.datePayFinancial AS column2Report,
                    f.methodPayment AS column3Report,
                    f.typeTreasurerFinancial AS column4Report,
                    SUM(f.valueAliquot) AS column5Report,
                    (SELECT SUM(f1.valueProduct) 
                        FROM financial f1 
                        WHERE f1.store = ".getStore()." AND f1.description = 'Aporte' 
                        GROUP BY f1.methodPayment, f1.datePayFinancial, f1.typeTreasurerFinancial 
                        HAVING f1.datePayFinancial = CURDATE()
                    ) AS column6Report
                FROM financial f 
                WHERE f.store = ".getStore()." AND f.description <> 'Aporte'
                GROUP BY f.methodPayment, f.datePayFinancial, f.typeTreasurerFinancial
                HAVING f.datePayFinancial = CURDATE()
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
    
    public function reportDebtors(){
        try{
            $sql = "
                SELECT 
                    c.nameAnimal AS column1Report,
                    c.owner AS column2Report,
                    c.phone1 AS column3Report,
                    d.totalPrice AS column4Report,
                    d.idDiary AS column5Report,
                    d.dateHour AS column6Report
                FROM diary d 
                LEFT JOIN sales s ON (d.idDiary = s.diary_idDiary)
                LEFT JOIN client c ON (d.client_idClient = c.idClient)
                WHERE d.STATUS = 2 AND s.idSales IS NULL AND d.store = ".getStore()."
            ";

            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
            foreach ($list as $row)
                $f_list[] = $this->showObject($row);

            return $f_list;
            
        }catch(Exception $e){
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