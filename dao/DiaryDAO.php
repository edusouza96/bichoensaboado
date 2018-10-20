<?php
class DiaryDAO
{
   
    public static $instance;
    private $sqlWhere = "";
   
    public function __construct()
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include_once($path."/bichoensaboado/class/Conexao.php");
        include_once($path."/bichoensaboado/class/DiaryClass.php");
        include_once($path."/bichoensaboado/dao/ClientDAO.php");
        include_once($path."/bichoensaboado/dao/ServicDAO.php");
        include_once($path."/bichoensaboado/dao/PackageDAO.php");
    }
   
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DiaryDAO();
        }
   
        return self::$instance;
    }
   
    public function addWhere($operator, $value)
    {
        $this->sqlWhere .= $operator.' '.$value;
    }
      
    public function Insert(DiaryClass $diary)
    {
        try {
            $sql = "INSERT INTO diary (    
                  client_idClient,
                  search,
                  servic_idServic,
                  price,
                  servicVet_idServic,
                  priceVet,
                  deliveryPrice,
                  totalPrice,
                  dateHour,
                  package_idPackage
                  ) VALUES (
                  :client_idClient,
                  :search,
                  :servic_idServic,
                  :price,
                  :servicVet_idServic,
                  :priceVet,
                  :deliveryPrice,
                  :totalPrice,
                  :dateHour,
                  :package_idPackage)";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":client_idClient", $diary->client);
            $p_sql->bindValue(":search", $diary->search);
            $p_sql->bindValue(":servic_idServic", $diary->servic);
            $p_sql->bindValue(":price", $diary->price);
            $p_sql->bindValue(":servicVet_idServic", $diary->servicVet);
            $p_sql->bindValue(":priceVet", $diary->priceVet);
            $p_sql->bindValue(":deliveryPrice", $diary->deliveryPrice);
            $p_sql->bindValue(":totalPrice", $diary->totalPrice);
            $p_sql->bindValue(":dateHour", $diary->dateHour);
            $p_sql->bindValue(":package_idPackage", $diary->package);

            $p_sql->execute();
            return Conexao::getInstance()->lastInsertId();
        } catch (Exception $e) {
            header("HTTP/1.0 404 Not Found");
            return $e."\nOcorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
   

    public function UpdateStatus($idDiary, $status)
    {
        try {
            $sqlFieldUpdate = '';
            if ($status == 1) {
                $sqlFieldUpdate = ', checkinHourDiary = :checkinHourDiary';
            } elseif ($status == 2) {
                $sqlFieldUpdate = ', checkoutHourDiary = :checkoutHourDiary';
            }

            $sql = "UPDATE diary set status = :status ".$sqlFieldUpdate." WHERE idDiary = :idDiary";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":status", $status);
            $p_sql->bindValue(":idDiary", $idDiary);
            if ($status == 1) {
                $p_sql->bindValue(":checkinHourDiary", date('H:i:s'));
            } elseif ($status == 2) {
                $p_sql->bindValue(":checkoutHourDiary", date('H:i:s'));
            }
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function UpdateCompanion($idDiary, $companion)
    {
        try {
            $sql = "UPDATE diary set
                        companion = :companion
                    WHERE idDiary = :idDiary";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":companion", $companion);
            $p_sql->bindValue(":idDiary", $idDiary);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
      

    public function Update(DiaryClass $diary)
    {
        try {
            $sql = "UPDATE diary set
                        client_idClient   = :client_idClient,
                        search            = :search,
                        servic_idServic   = :servic_idServic,
                        price             = :price,
                        servicVet_idServic= :servicVet_idServic,
                        priceVet          = :priceVet,
                        deliveryPrice     = :deliveryPrice,
                        totalPrice        = :totalPrice,
                        dateHour          = :dateHour,
                        status            = :status,
                        package_idPackage = :package_idPackage
                    WHERE idDiary = :idDiary";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":client_idClient", $diary->client->idClient);
            $p_sql->bindValue(":search", $diary->search);
            $p_sql->bindValue(":servic_idServic", is_null($diary->servic) ? null : $diary->servic->idServic);
            $p_sql->bindValue(":price", $diary->price);
            $p_sql->bindValue(":servicVet_idServic", is_null($diary->servicVet) ? null : $diary->servicVet->idServic);
            $p_sql->bindValue(":priceVet", $diary->priceVet);
            $p_sql->bindValue(":deliveryPrice", $diary->deliveryPrice);
            $p_sql->bindValue(":totalPrice", $diary->totalPrice);
            $p_sql->bindValue(":dateHour", $diary->dateHour);
            $p_sql->bindValue(":status", $diary->status);
            $p_sql->bindValue(":package_idPackage", $diary->package->idPackage ? $diary->package->idPackage : 0);
            $p_sql->bindValue(":idDiary", $diary->idDiary);
            
            return $p_sql->execute();
        } catch (Exception $e) {
            print "#02xD - Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
      
    public function Delete($idDiary)
    {
        try {
            $sql = "DELETE FROM diary WHERE idDiary = :idDiary";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idDiary", $idDiary);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
   
      
   
    public function SearchId($idDiary)
    {
        try {
            $sql = "SELECT * FROM diary WHERE idDiary = :idDiary";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idDiary", $idDiary);
            $p_sql->execute();
            return $this->ShowObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "#01xD - Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
   
     
    public function SearchAll()
    {
        try {
            $sql = "SELECT * FROM diary LEFT JOIN package ON ( package.idPackage = diary.package_idPackage ) order by dateHour";
            $result = Conexao::getInstance()->query($sql);
            $list = $result->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
   
            foreach ($list as $row) {
                $f_list[] = $this->ShowObject($row);
            }
   
            return $f_list;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
   
    public function SearchDate($dateHour)
    {
        try {
            $sql = "SELECT * FROM diary WHERE (SELECT SUBSTRING(dateHour, 1, 10 )) = :dateHour ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":dateHour", $dateHour);
            $p_sql->execute();
            $list = $p_sql->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
   
            foreach ($list as $row) {
                $f_list[] = $this->ShowObject($row);
            }
   
            return $f_list;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function SearchDateHour($dateHour)
    {
        try {
            $sql = "SELECT  * FROM diary LEFT JOIN sales ON (diary.idDiary = sales.diary_idDiary) WHERE dateHour = :dateHour AND companion in ('true','false') ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":dateHour", $dateHour);
            $p_sql->execute();
            $list = $p_sql->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
   
            foreach ($list as $row) {
                $f_list[] = $this->ShowObject($row);
            }
   
            return $f_list;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function SearchCompanion($idDiary)
    {
        try {
            $sql = "SELECT * FROM diary WHERE companion = :companion ".$this->sqlWhere;
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":companion", $idDiary);
            $p_sql->execute();
            $list = $p_sql->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
   
            foreach ($list as $row) {
                $f_list[] = $this->ShowObject($row);
            }
   
            return $f_list;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    private function ShowObject($row)
    {
          
        $diary = new DiaryClass();
        $diary->idDiary         = ($row['idDiary']);
        $diary->client          = ClientDAO::getInstance()->SearchId($row['client_idClient']);
        $diary->search          = ($row['search']);
        $diary->servic          = ServicDAO::getInstance()->SearchId($row['servic_idServic']);
        $diary->price           = ($row['price']);
        $diary->servicVet       = ServicDAO::getInstance()->SearchId($row['servicVet_idServic']);
        $diary->priceVet        = ($row['priceVet']);
        $diary->deliveryPrice   = ($row['deliveryPrice']);
        $diary->totalPrice      = ($row['totalPrice']);
        $diary->dateHour        = ($row['dateHour']);
        $diary->status          = ($row['status']);
        $diary->package          = PackageDAO::getInstance()->SearchId($row['package_idPackage']);
        $diary->pay = isset($row['idSales']);
        return $diary;
    }
}
