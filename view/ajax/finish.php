<?php
  $idDiary = $_GET['idDiary'];
  $status = $_GET['status'];
  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/DiaryDAO.php");
  include_once($path."/bichoensaboado/class/DiaryClass.php");
  
  $diaryDao = new DiaryDAO();
  $response = $diaryDao->UpdateStatus($idDiary,$status);
  if($status == -1){
    $response = $diaryDao->Delete($idDiary);
  }
  echo $response."|".$idDiary."|".$status;    
?>

