<?
header('Content-Type: text/html; charset=UTF-8');
require_once("ConexaoMysql.php");
$mySQL = new MySQL;
   $ownerFind = array();
   $owner = $_GET['owner'];
   if($owner != ''){
    $rs = $mySQL->executeQuery("SELECT * FROM client where owner LIKE '%".$owner."%';");
    
    while ($row = mysql_fetch_array($rs)){

      array_push($ownerFind, $row[3]."_".$row[4]."_".$row[5]."_".$row[6]."_".$row[7]);
    }
    
   }
    echo implode(',' , $ownerFind) ;

$mySQL->disconnect();
?>

