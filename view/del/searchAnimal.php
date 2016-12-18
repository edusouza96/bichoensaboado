<?
header('Content-Type: text/html; charset=UTF-8');
require_once("ConexaoMysql.php");
$mySQL = new MySQL;
   $ownerFind = array();
   $nameAnimal = $_GET['nameAnimal'];
   if($nameAnimal != ''){
    $rs = $mySQL->executeQuery("SELECT * FROM client where nameAnimal LIKE '%".$nameAnimal."%';");
    
    while ($row = mysql_fetch_array($rs)){

      array_push($ownerFind, $row[0]."_".$row[1]);
    }
    
   }
    echo implode(',' , $ownerFind) ;

$mySQL->disconnect();
?>

