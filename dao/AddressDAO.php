<?php
class AddressDAO
{
    public static $instance;

    public function __construct()
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include_once $path . "/bichoensaboado/class/Conexao.php";
        include_once $path . "/bichoensaboado/class/AddressClass.php";
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new AddressDAO();
        }

        return self::$instance;
    }

    public function Insert(AddressClass $address)
    {
        try {
            $sql = "INSERT INTO address (
                district,
                street,
                valuation
                )VALUES (
                :district,
                :street,
                :valuation)";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":district", $address->district);
            $p_sql->bindValue(":street", utf8_decode($address->street));
            $p_sql->bindValue(":valuation", $address->valuation);

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function Update(AddressClass $address)
    {
        try {
            $sql = "UPDATE address set
                        district  = :district,
                        street    = :street,
                        valuation = :valuation
                    WHERE idAddress = :idAddress";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":idAddress", $address->idAddress);
            $p_sql->bindValue(":district", $address->district);
            $p_sql->bindValue(":street", utf8_decode($address->street));
            $p_sql->bindValue(":valuation", $address->valuation);

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function Delete($idAddress)
    {
        try {
            $sql = "DELETE FROM address WHERE idAddress = :idAddress";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idAddress", $idAddress);

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function SearchByName($name)
    {
        try {
            $sql = "SELECT * FROM address WHERE district LIKE :name ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $name = '%' . $name . '%';
            $p_sql->bindParam(':name', $name, PDO::PARAM_STR);
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

    public function SearchId($idAddress)
    {
        try {
            $sql = "SELECT * FROM address WHERE idAddress = :idAddress";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idAddress", $idAddress);
            $p_sql->execute();
            return $this->ShowObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    public function SearchAll()
    {
        try {
            $sql = "SELECT * FROM address order by district";
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

    private function ShowObject($row)
    {

        $address = new AddressClass();
        $address->AddressClass($row['idAddress'], utf8_encode($row['district']), utf8_encode($row['street']), $row['valuation']);
        return $address;
    }

}
