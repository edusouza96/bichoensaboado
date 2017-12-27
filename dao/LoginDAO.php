<?php
class LoginDAO
{
   
    public static $instance;
    private $sqlWhere = "";
   
    public function __construct()
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include_once($path."/bichoensaboado/class/Conexao.php");
        include_once($path."/bichoensaboado/class/LoginClass.php");
    }
   
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new LoginDAO();
        }
   
        return self::$instance;
    }
   
    public function insert(LoginClass $login)
    {
        try {
            $sql = "INSERT INTO login (    
                nameLogin,
                passwordLogin,
                role
                )VALUES (
                :nameLogin,
                :passwordLogin
                :role
                )";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":nameLogin",  $login->nameLogin);
            $p_sql->bindValue(":passwordLogin", $login->passwordLogin);
            $p_sql->bindValue(":role_idRole", $login->role);
            $p_sql->execute();
            $newIdLogin = Conexao::getInstance()->lastInsertId();
              
            return $newIdLogin;
        } catch (Exception $e) {
            print $e."Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function update(LoginClass $login)
    {
        try {
            $sql = "UPDATE login set idLogin = :idLogin";
            $loginList = $login->iterateVisible();
            foreach ($loginList as $key => $value) {
                if ($value != "") {
                    $sql .= ", ".$key." = '".$value."'";
                }
            }
            $sql .= " WHERE idLogin = :idLogin ORDER BY nameLogin";
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":idLogin", $login->idLogin);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

   
    public function delete($idLogin)
    {
        try {
            $sql = "DELETE FROM login WHERE idLogin = :idLogin";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idLogin", $idLogin);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
      
    public function addWhere($value)
    {
        $this->sqlWhere .= 'AND '.$value;
    }

    public function searchId($idLogin)
    {
        try {
            $sql = "SELECT * FROM login WHERE idLogin = :idLogin";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idLogin", $idLogin);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function searchAll()
    {
        try {
            $sql = "SELECT * FROM login WHERE 1=1 ".$this->sqlWhere;
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
   
    public function doLogin(LoginClass $login)
    {
        try {
            $sql = "SELECT * FROM login WHERE nameLogin = :nameLogin AND passwordLogin = :passwordLogin";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":nameLogin", $login->nameLogin);
            $p_sql->bindValue(":passwordLogin", $login->passwordLogin);
            $p_sql->execute();
            $result = $p_sql->fetch(PDO::FETCH_ASSOC);
            return ($result ? $this->showObject($result) : $result);
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    private function showObject($row)
    {
        $login = new LoginClass();
        $login->idLogin = $row['idLogin'];
        $login->nameLogin = $row['nameLogin'];
        $login->passwordLogin = $row['passwordLogin'];
        $login->role = $row['role_idRole'];
        // $login->role = RoleDAO::getInstance()->searchId($row['role_idRole']);
        return $login;
    }
}
