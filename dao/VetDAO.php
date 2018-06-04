<?php
class VetDAO
{
   
    public static $instance;
    private $sqlWhere = "";
   
    public function __construct()
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include_once($path."/bichoensaboado/class/Conexao.php");
        include_once($path."/bichoensaboado/class/VetClass.php");
        include_once($path."/bichoensaboado/dao/ClientDAO.php");
        include_once($path."/bichoensaboado/dao/ServicDAO.php");
    }
   
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new VetDAO();
        }
   
        return self::$instance;
    }
   
    public function addWhere($operator, $value)
    {
        $this->sqlWhere .= $operator.' '.$value;
    }
      
    public function Insert(VetClass $vet)
    {
        try {
            $sql = "INSERT INTO vet (    
                  client_idClient,
                  servic_idServic,
                  search,
                  price,
                  deliveryPrice,
                  totalPrice,
                  dateHour
                  ) VALUES (
                  :client_idClient,
                  :servic_idServic,
                  :search,
                  :price,
                  :deliveryPrice,
                  :totalPrice,
                  :dateHour)";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":client_idClient", $vet->client);
            $p_sql->bindValue(":servic_idServic", $vet->servic);
            $p_sql->bindValue(":search", $vet->search);
            $p_sql->bindValue(":price", $vet->price);
            $p_sql->bindValue(":deliveryPrice", $vet->deliveryPrice);
            $p_sql->bindValue(":totalPrice", $vet->totalPrice);
            $p_sql->bindValue(":dateHour", $vet->dateHour);

            $p_sql->execute();
            return Conexao::getInstance()->lastInsertId();
        } catch (Exception $e) {
            return $e."Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
   

    public function UpdateStatus($idVet, $status)
    {
        try {
            $sqlFieldUpdate = '';
            if ($status == 1) {
                $sqlFieldUpdate = ', checkinHour = :checkinHour';
            } elseif ($status == 2) {
                $sqlFieldUpdate = ', checkoutHour = :checkoutHour';
            }

            $sql = "UPDATE vet set status = :status ".$sqlFieldUpdate." WHERE idVet = :idVet";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":status", $status);
            $p_sql->bindValue(":idVet", $idVet);
            if ($status == 1) {
                $p_sql->bindValue(":checkinHour", date('H:i:s'));
            } elseif ($status == 2) {
                $p_sql->bindValue(":checkoutHour", date('H:i:s'));
            }
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function Update(VetClass $vet)
    {
        try {
            $sql = "UPDATE vet set
                        client_idClient   = :client_idClient,
                        servic_idServic   = :servic_idServic,
                        search            = :search,
                        price             = :price,
                        deliveryPrice     = :deliveryPrice,
                        totalPrice        = :totalPrice,
                        dateHour          = :dateHour,
                        status            = :status
                    WHERE idVet = :idVet";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":client_idClient", $vet->client->idClient);
            $p_sql->bindValue(":servic_idServic", $vet->servic->idServic);
            $p_sql->bindValue(":search", $vet->search);
            $p_sql->bindValue(":price", $vet->price);
            $p_sql->bindValue(":deliveryPrice", $vet->deliveryPrice);
            $p_sql->bindValue(":totalPrice", $vet->totalPrice);
            $p_sql->bindValue(":dateHour", $vet->dateHour);
            $p_sql->bindValue(":status", $vet->status);
            $p_sql->bindValue(":idVet", $vet->idVet);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
      
    public function Delete($idVet)
    {
        try {
            $sql = "DELETE FROM vet WHERE idVet = :idVet";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idVet", $idVet);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
   
      
   
    public function SearchId($idVet)
    {
        try {
            $sql = "SELECT * FROM vet WHERE idVet = :idVet";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idVet", $idVet);
            $p_sql->execute();
            return $this->ShowObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
   
     
    public function SearchAll()
    {
        try {
            $sql = "SELECT * FROM vet order by dateHour";
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
            $sql = "SELECT * FROM vet WHERE (SELECT SUBSTRING(dateHour, 1, 10 )) = :dateHour ";
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
            $sql = "SELECT * FROM vet WHERE dateHour = :dateHour";
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

    private function ShowObject($row)
    {
          
        $vet = new VetClass();
        $vet->idVet         = ($row['idVet']);
        $vet->client          = ClientDAO::getInstance()->SearchId($row['client_idClient']);
        $vet->servic          = ServicDAO::getInstance()->SearchId($row['servic_idServic']);
        $vet->search          = ($row['search']);
        $vet->price           = ($row['price']);
        $vet->deliveryPrice   = ($row['deliveryPrice']);
        $vet->totalPrice      = ($row['totalPrice']);
        $vet->dateHour        = ($row['dateHour']);
        $vet->status          = ($row['status']);
        return $vet;
    }
}
