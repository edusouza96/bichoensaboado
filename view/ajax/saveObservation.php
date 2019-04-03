<?php

    $id = $_POST['id'];
    $observation = $_POST['observation'];
    
    $path = $_SERVER['DOCUMENT_ROOT']; 

    include_once($path."/bichoensaboado/dao/DiaryDAO.php");

    $diaryDAO = new DiaryDAO();
    $diaryDAO->setObservation($id, $observation);
