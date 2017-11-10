<?php
  $id = $_GET['id'];
  $module = $_GET['module'];
  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/".$module."DAO.php");
  include_once($path."/bichoensaboado/class/".$module."Class.php");
  
  
  $module .= "DAO";
  $moduleDao = new ${'module'}();
  $response = $moduleDao->delete($id);
  echo $response;    
?>

