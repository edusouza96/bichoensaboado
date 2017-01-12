<?php
  date_default_timezone_set('America/Sao_Paulo');
  $paramSave = $_GET['paramSave'];
  $idField = $_GET['idField'];
  $path = $_SERVER['DOCUMENT_ROOT']; 

  include_once($path."/bichoensaboado/dao/DiaryDAO.php");
  include_once($path."/bichoensaboado/class/DiaryClass.php");
  
  $paramDiary = explode('|', $paramSave);
  if($paramDiary[1] == -1){
    for($i=0; $i<4; $i++){
       
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
      
      $paramDiary[6] = new DateTime($paramDiary[6]);
      $paramDiary[6]->add(new DateInterval('P7D'));
      $paramDiary[6]=$paramDiary[6]->format('Y-m-d H:i');

      $diaryDao = new DiaryDAO();
      $response = $diaryDao->Insert($diary);
    }
  }else if($paramDiary[1] == -2){
    for($i=0; $i<2; $i++){
       
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
      
      $paramDiary[6] = new DateTime($paramDiary[6]);
      $paramDiary[6]->add(new DateInterval('P14D'));
      $paramDiary[6]=$paramDiary[6]->format('Y-m-d H:i');

      $diaryDao = new DiaryDAO();
      $response = $diaryDao->Insert($diary);
    }
  }else if($paramDiary[1] > 0){
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
  }
 

  echo $response;    
?>

