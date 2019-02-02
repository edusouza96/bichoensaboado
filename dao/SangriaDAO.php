<?php
class SangriaDAO
{
   
    public static $instance;
    private $sqlWhere = "";
   
    public function __construct()
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include_once($path."/bichoensaboado/class/Conexao.php");
        include_once($path."/bichoensaboado/class/SangriaClass.php");
    }
   
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new SangriaDAO();
        }
   
        return self::$instance;
    }
   
    public function insert(SangriaClass $sangria)
    {
        try {
            $sql = "INSERT INTO sangria (    
                value,
                date,
                store
                )VALUES (
                :value,
                :date,
                :store
                )";
   
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":value", $sangria->value);
            $p_sql->bindValue(":date", $sangria->date);
            $p_sql->bindValue(":store", $sangria->store);
            $p_sql->execute();
            $newIdSangria = Conexao::getInstance()->lastInsertId();
              
            return $newIdSangria;
        } catch (Exception $e) {
            print $e."Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function update(SangriaClass $sangria)
    {
        try {
            $sql = "UPDATE sangria set idSangria = :idSangria";
            $sangriaList = $sangria->iterateVisible();
            foreach ($sangriaList as $key => $value) {
                if ($value != "") {
                    $sql .= ", ".$key." = '".$value."'";
                }
            }
            $sql .= " WHERE idSangria = :idSangria";
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":idSangria", $sangria->idSangria);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

   
    public function delete($idSangria)
    {
        try {
            $sql = "DELETE FROM sangria WHERE idSangria = :idSangria";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idSangria", $idSangria);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
      
    public function addWhere($value)
    {
        $this->sqlWhere .= 'AND '.$value;
    }

    public function searchId($idSangria)
    {
        try {
            $sql = "SELECT * FROM sangria WHERE idSangria = :idSangria";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idSangria", $idSangria);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function searchAll()
    {
        try {
            $sql = "SELECT * FROM sangria WHERE 1=1 ".$this->sqlWhere;
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
        $sangria = new SangriaClass();
        $sangria->idSangria = $row['idSangria'];
        $sangria->value = $row['value'];
        $sangria->date = $row['date'];
        $sangria->store = $row['store'];
        return $sangria;
    }
}
