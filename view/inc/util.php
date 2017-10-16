
<?php

function generationColorRGB(){
    $color1 = mt_rand(16, 255);
    $color2 = mt_rand(16, 255);
    $color3 = mt_rand(16, 255);
    return "#".dechex($color1).dechex($color2).dechex($color3);
}
?>