<?php
function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}
if($_SERVER['SERVER_NAME'] == 'localhost'){
    $urlBase = "http://".$_SERVER['SERVER_NAME']."";
}else{
    $urlBase = "https://".$_SERVER['SERVER_NAME'];
}
Redirect($urlBase.'/bichoensaboado/view/index.php', false);
?>