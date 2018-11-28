<?php
    
    error_reporting(0);    
    $path = $_SERVER['DOCUMENT_ROOT']; 
    $search = $_POST['search'];
    include_once($path."/bichoensaboado/dao/FinancialDAO.php");
    include_once $path."/bichoensaboado/view/inc/util.php";
    $financialDao = new FinancialDAO();
    $financialDao->addWhere("registerBuy IS NOT NULL ");
    if($search){
        $financialDao->addWhere("registerBuy = ".$search);
    }else{
        $financialDao->addWhere(" datePayFinancial = CURDATE() ");
        $financialDao->addWhere(" f.store = ".getStore());
    }
    $financialList = $financialDao->searchAllSales();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Vendas do Dia</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <script language="javascript" src="../../js/jquery.min.js"></script>
        <script language="javascript" src="../../js/ajax.js?v=2"></script>
        <script language="javascript" src="../../js/jquery-1.10.2.js"></script>
        <script language="javascript" src="../../js/bootstrap.min.js"></script>
        <script language="javascript" src="../../js/jquery-ui.js"></script>
        <script language="javascript" src="../../js/functionsModules.js?v=3"></script>
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
        <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.min.css">
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Vendas do dia</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
       
        <form role="form" method="POST">
            <div class="form-group col-xs-4 col-sm-4 col-lg-4 col-md-4">
                <div class="input-group">
                    <input type="number" class="form-control" id="searchBar" name="search" placeholder="Código Venda" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info" value="Buscar">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
                <br>
            </div>
        </form>
        <input type="hidden" name="idFinancial" id="idFinancial">
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered">
            <thead>
                <tr>
                    <th class="col-md-2">Código Venda</th>
                    <th class="col-md-5">Descrição</th>
                    <th class="col-md-2">Valor</th>
                    <th class="col-md-1">Estornar</th>
                </tr>
            </thead>
            <tbody >
                <?php
                    foreach($financialList as $financial){
                ?>
                    <tr>
                        <td><?=$financial->registerBuy?></td>
                        <td><?=$financial->sales?></td>
                        <td>R$ <?=$financial->valueProduct?></td>
                        <td><i class="fa fa-undo cursor" aria-hidden="true" data-toggle='modal' data-target='#modalCanc' onClick="setIdFinancial(<?=$financial->idFinancial?>)"></i></td>
                    </tr>
                <?php
                    }
                ?>
                
            </tbody>
           
        </table>

        <!-- Modal de estorno -->
        <div class="modal fade" id="modalCanc" role="dialog">
            <div class="modal-dialog">
                    
                <!-- Modal content-->
                <div class="modal-content" style="width: 50%;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Estorno Venda</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row"> <!--div line password-->
                            <div class="col-xs-10 col-sm-10 col-lg-10 col-md-10"> <!--div password-->
                                <div class="form-group"> 
                                    <label for="password">Senha</label>
                                    <input type="password" id="password" name="password" class="form-control" value>
                                    <input type="hidden" id="idCanc" name="idCanc" class="form-control" value>
                                </div>
                            </div> <!-- end div password-->
                        </div><!-- end div line password-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" onClick="purchaseReversal();">Confirmar</button>                        
                    </div>
                </div>
                
            </div>
        </div>
        <!--Fim Modal de estorno-->
       
    </body>
</html>

<script>
    function purchaseReversal(){
        var idFinancial = $("#idFinancial").val();
        var password = document.getElementById('password').value; 
        if(password == '4518' || password == 'admin1996'){
            $.post( "../ajax/purchaseReversal.php", { 
                idFinancial: idFinancial,
            }).done(function( data ) {
                location.reload();
            });
        }else{
            alert('Senha Incorreta!');
        }
        
    }

    function setIdFinancial(idFinancial){
        $("#idFinancial").val(idFinancial);
    }


</script>