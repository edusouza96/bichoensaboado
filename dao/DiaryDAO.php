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
        include_once($path."/bichoensaboado/class/LoginClass.php");
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
            $hasAlreadyDateHour = $this->hasAlreadyDateHour($diary->dateHour, $diary->client);
            if($hasAlreadyDateHour === false){
                session_start();
                $user = unserialize($_SESSION['userOnline']);

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
                    package_idPackage,
                    store
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
                    :package_idPackage,
                    :store)";
    
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
                $p_sql->bindValue(":store", $user->store);

                $p_sql->execute();
                return Conexao::getInstance()->lastInsertId();
            }else{
                return $hasAlreadyDateHour;
            }
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
            $hasAlreadyDateHour = $this->hasAlreadyDateHour($diary->dateHour, $diary->client->idClient, $diary->idDiary);
            if($hasAlreadyDateHour === false){
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
            }else{
                $sql = "UPDATE diary set
                            client_idClient   = :client_idClient,
                            search            = :search,
                            servic_idServic   = :servic_idServic,
                            price             = :price,
                            servicVet_idServic= :servicVet_idServic,
                            priceVet          = :priceVet,
                            deliveryPrice     = :deliveryPrice,
                            totalPrice        = :totalPrice,
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
                $p_sql->bindValue(":status", $diary->status);
                $p_sql->bindValue(":package_idPackage", $diary->package->idPackage ? $diary->package->idPackage : 0);
                $p_sql->bindValue(":idDiary", $diary->idDiary);
            
                return $p_sql->execute();
            }
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
        $user = unserialize($_SESSION['userOnline']);

        try {
            if($user->role == 3){
                $sql = "SELECT diary.*, MIN(sales.idSales) as idSales FROM diary LEFT JOIN sales ON (diary.idDiary = sales.diary_idDiary) WHERE dateHour = :dateHour AND companion in ('true','false') AND store = :store GROUP BY diary.idDiary";
                $p_sql = Conexao::getInstance()->prepare($sql);
                $p_sql->bindValue(":dateHour", $dateHour);
                $p_sql->bindValue(":store", $user->store);
            }else{
                $sql = "SELECT diary.*, MIN(sales.idSales) as idSales FROM diary LEFT JOIN sales ON (diary.idDiary = sales.diary_idDiary) WHERE dateHour = :dateHour AND companion in ('true','false') GROUP BY diary.idDiary";
                $p_sql = Conexao::getInstance()->prepare($sql);
                $p_sql->bindValue(":dateHour", $dateHour);
            }

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

    public function searchByNameAnimal($nameAnimal) {
        try {
            $sql = "SELECT d.* FROM diary d LEFT JOIN client c ON (c.idClient = d.client_idClient) WHERE c.nameAnimal LIKE :nameAnimal ORDER BY c.owner, d.dateHour desc";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $nameAnimal = '%' . $nameAnimal . '%';
            $p_sql->bindParam(':nameAnimal', $nameAnimal, PDO::PARAM_STR);
            $p_sql->execute();
            $list = $p_sql->fetchAll(PDO::FETCH_ASSOC);
            $f_list = array();
            foreach ($list as $row){
                $f_list[] = $this->ShowObject($row);
            }
            return $f_list;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function setObservation($id, $observation)
    {
        try {
            $sql = "UPDATE diary set observation = :observation WHERE idDiary = :id";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":observation", $observation);
            $p_sql->bindValue(":id", $id);
            
            return $p_sql->execute();
        } catch (Exception $e) {
            var_dump($e);
            header("HTTP/1.0 500");
            print "#10xD - Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    private function hasAlreadyDateHour($dateHour, $idClient, $id = 0)
    {
        try {
            $sql = "SELECT * FROM diary WHERE dateHour = :dateHour AND client_idClient = :idClient AND idDiary <> :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":dateHour", $dateHour);
            $p_sql->bindValue(":idClient", $idClient);
            $p_sql->bindValue(":id", $id);

            $p_sql->execute();
            $list = $p_sql->fetchAll(PDO::FETCH_ASSOC);

            if(count($list) > 0){
                return $list[0]['idDiary'];
            }
            
            return false;
        } catch (Exception $e) {
            print "#03xD - Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
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
        $diary->package         = PackageDAO::getInstance()->SearchId($row['package_idPackage']);
        $diary->store           = ($row['store']);
        $diary->checkinHourDiary = ($row['checkinHourDiary']);
        $diary->pay             = isset($row['idSales']);
        @$diary->observation     = ($row['observation']);
        return $diary;
    }
}
