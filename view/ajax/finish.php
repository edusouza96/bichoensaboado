<?php
  date_default_timezone_set('America/Sao_Paulo');
  $idDiary = $_GET['idDiary'];
  $status = $_GET['status'];
  $path = $_SERVER['DOCUMENT_ROOT']; 
  $dateHour = '';

  include_once($path."/bichoensaboado/dao/DiaryDAO.php");
  include_once($path."/bichoensaboado/class/DiaryClass.php");
  
  $diaryDao = new DiaryDAO();
  $response = $diaryDao->UpdateStatus($idDiary,$status);
  if($status == -1){
    $response = $diaryDao->Delete($idDiary);
  }
  if($status == 1){
    $diary = $diaryDao->SearchId($idDiary);
    $dataHourDB = new DateTime($diary->dateHour);
    $date = $dataHourDB->format('Y-m-d');
    $hour = $dataHourDB->format('H:i');
    $dateHour = "|".$hour."|".$date."|";

  }
  echo $response."|".$idDiary."|".$status."".$dateHour;    
?>

