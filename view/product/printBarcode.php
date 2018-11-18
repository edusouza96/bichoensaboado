<?php
$barcode = $_GET['barcode'];
$quantityPrint = isset($_GET['quantityPrint']) ? $_GET['quantityPrint'] : 1;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title></title>
        <link rel="stylesheet" href="/bichoensaboado/css/bootstrap.min.css">
        <style>
            @media print {
                form{ 
                    display:none; 
                }

                .barcode-content{
                    margin: 30px 0px;
                }
            }

            form{
                margin: 30px 10px;
            }

            @page 
            {
                size: auto;   /* auto is the initial value */
                margin: 0mm;  /* this affects the margin in the printer settings */
            }


        </style>
    </head>
    <body>
        <form class="setup-print form-inline">
            <label>Número de Códigos de barras a Imprimir</label>
            <input type="number" class="form-control" name="quantityPrint" style="width:100px;">
            <input type="hidden" class="form-control" name="barcode" value="<?=$barcode?>">
            <input type="submit" value="Recarregar" class="btn btn-primary">
            <button class="btn btn-primary glyphicon glyphicon-print" onclick="window.print();"> Imprimir</button>
        </form>

        <?php for ($i = 0; $i < $quantityPrint; $i++) {?>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 barcode-content">
                <img src="../inc/barcode.php?text=<?=$barcode?>&print=true&size=40" />
            </div>
        <?php }?>
    </body>
</html>
