<?php
class FinancialDAO
{

    public static $instance;
    private static $sqlWhere;

    public function __construct()
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include_once $path . "/bichoensaboado/class/Conexao.php";
        include_once $path . "/bichoensaboado/class/FinancialClass.php";
        include_once $path . "/bichoensaboado/dao/CenterCostDAO.php";
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new FinancialDAO();
        }

        return self::$instance;
    }

    public function insert(FinancialClass $financial)
    {
        try {
            $sql = "INSERT INTO financial (
                registerBuy,
                sales_idSales,
                valueProduct,
                description,
                dateDueFinancial,
                datePayFinancial,
                center_cost_idCenterCost,
                methodPayment,
                numberPlotsFinancial,
                typeTreasurerFinancial,
                valueAliquot
                )VALUES (
                :registerBuy,
                :sales,
                :valueProduct,
                :description,
                :dateDueFinancial,
                :datePayFinancial,
                :centerCost,
                :methodPayment,
                :numberPlotsFinancial,
                :typeTreasurerFinancial,
                :valueAliquot)";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":registerBuy", $financial->registerBuy);
            $p_sql->bindValue(":sales", $financial->sales);
            $p_sql->bindValue(":valueProduct", $financial->valueProduct);
            $p_sql->bindValue(":description", $financial->description);
            $p_sql->bindValue(":dateDueFinancial", $financial->dateDueFinancial);
            $p_sql->bindValue(":datePayFinancial", $financial->datePayFinancial);
            $p_sql->bindValue(":centerCost", $financial->centerCost);
            $p_sql->bindValue(":methodPayment", $financial->methodPayment);
            $p_sql->bindValue(":numberPlotsFinancial", $financial->numberPlotsFinancial);
            $p_sql->bindValue(":typeTreasurerFinancial", $financial->typeTreasurerFinancial);
            $p_sql->bindValue(":valueAliquot", $financial->valueAliquot);
            $p_sql->execute();
            return Conexao::getInstance()->lastInsertId();
        } catch (Exception $e) {
            print $e . "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function update(FinancialClass $financial)
    {
        try {
            $sql = "UPDATE financial set idFinancial = :idFinancial";
            $financialList = $financial->iterateVisible();
            foreach ($financialList as $key => $value) {
                if ($value != "") {
                    $sql .= ", " . $key . " = '" . $value . "'";
                }
            }
            $sql .= " WHERE idFinancial = :idFinancial";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":idFinancial", $financial->idFinancial);

            return $p_sql->execute();
        } catch (Exception $e) {
            print $e . "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function delete($idFinancial)
    {
        try {
            $sql = "DELETE FROM financial WHERE idFinancial = :idFinancial";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idFinancial", $idFinancial);

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function addWhere($value)
    {
        $this->sqlWhere .= 'AND ' . $value;
    }

    public function searchId($idFinancial)
    {
        try {
            $sql = "SELECT * FROM financial WHERE idFinancial = :idFinancial";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idFinancial", $idFinancial);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function searchAll()
    {
        try {
            $sql = "SELECT * FROM financial WHERE 1=1 " . $this->sqlWhere;
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

    public function searchAllSales()
    {
        try {
            $sql = "
                SELECT f.*, s.*, p.*, d.*, v.*, c.* FROM financial f 
                INNER JOIN sales s ON (f.sales_idSales = s.idSales) 
                LEFT JOIN product p ON (s.product_idProduct = p.idProduct) 
                LEFT JOIN diary d ON (s.diary_idDiary = d.idDiary) 
                LEFT JOIN vet v ON (s.vet_idVet = v.idVet) 
                LEFT JOIN servic c ON (d.servic_idServic = c.idServic OR v.servic_idServic = c.idServic)
                WHERE 1=1 " . $this->sqlWhere;
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();

            foreach ($list as $row) {
                $f_list[] = $this->buildObject($row);
            }

            return $f_list;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta açãoo, tente novamente mais tarde.";
        }
    }

    private function showObject($row)
    {
        $financial = new FinancialClass();
        $financial->idFinancial = $row['idFinancial'];
        $financial->description = $row['description'];
        $financial->dateDueFinancial = $row['dateDueFinancial'];
        $financial->datePayFinancial = $row['datePayFinancial'];
        $financial->valueProduct = $row['valueProduct'];
        $financial->registerBuy = $row['registerBuy'];
        $financial->sales = $row['sales_idSales'];
        $financial->centerCost = CenterCostDAO::getInstance()->searchId($row['center_cost_idCenterCost']);
        $financial->methodPayment = $row['methodPayment'];
        $financial->numberPlotsFinancial = $row['numberPlotsFinancial'];
        $financial->typeTreasurerFinancial = $row['typeTreasurerFinancial'];
        $financial->valueAliquot = $row['valueAliquot'];

        return $financial;
    }

    private function buildObject($row)
    {
        $financial = new FinancialClass();
        $financial->idFinancial = $row['idFinancial'];
        $financial->description = $row['description'];
        $financial->dateDueFinancial = $row['dateDueFinancial'];
        $financial->datePayFinancial = $row['datePayFinancial'];
        $financial->valueProduct = $row['valueProduct'];
        $financial->registerBuy = $row['registerBuy'];
        $financial->sales = ($row['nameProduct'] ? $row['nameProduct'] : $row['nameServic']);
        $financial->centerCost = CenterCostDAO::getInstance()->searchId($row['center_cost_idCenterCost']);
        $financial->methodPayment = $row['methodPayment'];
        $financial->numberPlotsFinancial = $row['numberPlotsFinancial'];
        $financial->typeTreasurerFinancial = $row['typeTreasurerFinancial'];
        $financial->valueAliquot = $row['valueAliquot'];
        return $financial;
    }

}
