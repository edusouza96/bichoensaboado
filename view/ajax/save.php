<?php
  $paramSave = $_GET['paramSave'];
  $idField = $_GET['idField'];
  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/DiaryDAO.php");
  include_once($path."/bichoensaboado/class/DiaryClass.php");
  
  $paramDiary = explode('|', $paramSave);

  $diary = new DiaryClass();
  $diary->DiaryClass(0
                    , $paramDiary[0]
                    , $paramDiary[1]
                    , $paramDiary[2]
                    , $paramDiary[3]
                    , $paramDiary[4]
                    , $paramDiary[5]
                    , $paramDiary[6]
                    );

 
   $diaryDao = new DiaryDAO();
   $response = $diaryDao->Insert($diary);

  echo $response;    
?>

