<?php
function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}

$path = $_SERVER['SERVER_NAME']; 
if($path=='localhost'){
    $path .=':7777';
}
echo 'Opa! Estamos em constru��o!';
// Redirect('http://'.$path.'/bichoensaboado/view/financial/ListFinancial.php', false);
?>