<?php
  $idDiary = $_GET['idDiary'];
  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/DiaryDAO.php");
  include_once($path."/bichoensaboado/class/DiaryClass.php");
  
  $diaryDao = new DiaryDAO();
  $response = $diaryDao->UpdateStatus($idDiary);

  echo $response."|".$idDiary;    
?>

