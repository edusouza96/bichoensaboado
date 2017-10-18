<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <title>Relat�rios</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
    </head>
    <body>
        <div class="jumbotron">
            <h2>Relat�rios</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <div class="container">
            <div class="row"> 
                <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                    <div class="form-group">
                        <button class="btn btn-primary btn-size-report" onclick="redirectReport('reportSearchDoneByDistrict.php');">Buscas realizadas por Bairro</button>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                    <div class="form-group">
                        <button class="btn btn-primary btn-size-report" onclick="redirectReport('reportClientAttendedByDistrict.php');">Clientes Atendidos Por Bairro</button>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                    <div class="form-group">
                        <button class="btn btn-primary btn-size-report" onclick="redirectReport('reportClientAttendedByBreed.php');" >C�es atendidos por ra�a</button>
                    </div>
                </div>
            </div>

            <div class="row"> 
                <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                    <div class="form-group">
                        <button class="btn btn-primary btn-size-report" onclick="redirectReport('reportFinancialByExpenses.php');">Despesas por periodo</button>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                    <div class="form-group">
                        <button class="btn btn-primary btn-size-report" onclick="redirectReport('reportFinancialByInOut.php');">Movimenta��o financeira</button>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-4 col-lg-4 col-md-4">
                    <div class="form-group">
                        <button class="btn btn-primary btn-size-report" onclick="redirectReport('reportFinancialBySales.php');">Vendas por periodo</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script language="javascript" src="../../js/functionsModules.js?v=<?=rand(100, 500)?>"></script>
<script language="javascript" src="../../js/ajax.js?v=2"></script>