<?php
$currentStore = $_GET['currentStore'];
$path = $_SERVER['DOCUMENT_ROOT'];
include_once($path."/bichoensaboado/class/LoginClass.php");
session_start();
$dataLogin = unserialize($_SESSION['userOnline']);
if($currentStore == 1){
    $dataLogin->store = 2;
}else{
    $dataLogin->store = 1;
}
$_SESSION["userOnline"] = serialize($dataLogin);
echo true;
