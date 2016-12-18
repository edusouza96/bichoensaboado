<?
require_once("ConexaoMysql.php");
$mySQL = new MySQL;
$sql = "Insert into infousuario values 
    (0,'$_POST[hour]','$_POST[nameAnimal]','$_POST[breed]', '$_POST[owner]', '$_POST[search]', '$_POST[address]','$_POST[district]','$_POST[phone1]','$_POST[phone2]','$_POST[service]', '$_POST[price]', '$_POST[deliveryPrice]', '$_POST[tatalPrice]','$_POST[payment]')";
$rs = $mySQL->executeQuery($sql);

$mySQL->disconnect();
?>