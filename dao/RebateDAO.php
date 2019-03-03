<?php
class RebateDAO
{
   
    public static $instance;
    private $sqlWhere = "";
   
    public function __construct()
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include_once($path."/bichoensaboado/class/Conexao.php");
        include_once($path."/bichoensaboado/class/RebateClass.php");
    }
   
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new RebateDAO();
        }
   
        return self::$instance;
    }
   
    public function insert(RebateClass $rebate)
    {
        try {
            $sql = "INSERT INTO rebate (    
                descriptionRebate,
                valueRebate
                )VALUES (
                :descriptionRebate,
                :valueRebate
                )";
            $p_sql = Conexao::getInstance()->prepare($sql);
   
            $p_sql->bindValue(":descriptionRebate", utf8_decode($rebate->descriptionRebate));
            $p_sql->bindValue(":valueRebate",       $rebate->valueRebate);
            $p_sql->execute();
            $newIdRebate = Conexao::getInstance()->lastInsertId();
              
            return $newIdRebate;
        } catch (Exception $e) {
            print $e."Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function update(RebateClass $rebate)
    {
        try {
            $sql = "UPDATE rebate set idRebate = :idRebate";
            $rebateList = $rebate->iterateVisible();
            foreach ($rebateList as $key => $value) {
                if ($value != "") {
                    $sql .= ", ".$key." = '".$value."'";
                }
            }
            $sql .= " WHERE idRebate = :idRebate";
            $p_sql = Conexao::getInstance()->prepare(utf8_decode($sql));
   
            $p_sql->bindValue(":idRebate", $rebate->idRebate);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

   
    public function delete($idRebate)
    {
        try {
            $sql = "DELETE FROM rebate WHERE idRebate = :idRebate";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idRebate", $idRebate);
   
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
      
    public function addWhere($value)
    {
        $this->sqlWhere .= 'AND '.$value;
    }

    public function searchId($idRebate)
    {
        try {
            $sql = "SELECT * FROM rebate WHERE idRebate = :idRebate";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":idRebate", $idRebate);
            $p_sql->execute();
            return $this->showObject($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }
     
    public function searchAll()
    {
        try {
            $sql = "SELECT * FROM rebate WHERE 1=1 ".$this->sqlWhere;
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
        $rebate = new RebateClass();
        $rebate->idRebate = $row['idRebate'];
        $rebate->descriptionRebate = utf8_encode($row['descriptionRebate']);
        $rebate->valueRebate = $row['valueRebate'];
        $rebate->active = $row['active'];
        return $rebate;
    }
}
