<?php
    
    error_reporting(0);    
    $path = $_SERVER['DOCUMENT_ROOT']; 
    $search = $_POST['search'];
    include_once($path."/bichoensaboado/dao/FinancialDAO.php");
    $financialDao = new FinancialDAO();
    $financialDao->addWhere("registerBuy IS NOT NULL ");
    $financialDao->addWhere("datePayFinancial = CURDATE() ");
    if($search){
        $financialDao->addWhere("registerBuy = ".$search);
    }
    $financialList = $financialDao->searchAllSales();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Vendas do Dia</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <script language="javascript" src="../../js/ajax.js?v=2"></script>
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
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="col-md-2">Código Venda</th>
                    <th class="col-md-5">Descrição</th>
                    <th class="col-md-3">Valor</th>
                    <th class="col-md-1">Alterar</th>
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
                        <td class="text-center"><i class="fa fa-pencil" aria-hidden="true"></i></td>
                        <td class="text-center"><i class="fa fa-undo" aria-hidden="true"></i></td>
                    </tr>
                <?php
                    }
                ?>
                
            </tbody>
           
        </table>
       
    </body>
</html>