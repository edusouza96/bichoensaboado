
<?php
@session_start();

function generationColorRGB()
{
    $color1 = mt_rand(16, 255);
    $color2 = mt_rand(16, 255);
    $color3 = mt_rand(16, 255);
    return "#" . dechex($color1) . dechex($color2) . dechex($color3);
}

function dateUs2Br($dateUs)
{
    return date("d/m/Y", strtotime($dateUs));
}

function getStore()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once $path . "/bichoensaboado/class/LoginClass.php";
    $dataLogin = unserialize($_SESSION['userOnline']);
    return $dataLogin->store;
}

?>