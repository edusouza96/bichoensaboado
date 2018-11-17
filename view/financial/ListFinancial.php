<?php
    
    error_reporting(0);    
    $path = $_SERVER['DOCUMENT_ROOT']; 
    $search = $_POST['search'];
    include_once($path."/bichoensaboado/dao/FinancialDAO.php");
    $financialDao = new FinancialDAO();
    if(empty($search)){
        $financialDao->addWhere("registerBuy IS NULL ");
        $financialList = $financialDao->searchAll();
    }else{
        $financialDao->addWhere("description LIKE '%".$search."%' ");
        $financialList = $financialDao->searchAll();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Financeiro</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <script language="javascript" src="../../js/ajax.js?v=2"></script>
        <script language="javascript" src="../../js/functionsModules.js?v=3"></script>
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Financeiro</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <a href="SaveOutlay.php" class='btn btn-success btn-sm'style=" float: right;">
            <span class='glyphicon glyphicon-plus'></span> Registrar gastos
        </a>
        <form role="form" method="POST">
            <div class="form-group col-xs-4 col-sm-4 col-lg-4 col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchBar" name="search" placeholder="Buscar" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info" value="Buscar">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
                <br>
                <b>Exibir Registros de: </b>
                <input type="button" class="btn btn" onclick="showFinancial('financial-out','financial-in');" value="Saida">
                <input type="button" class="btn btn" onclick="showFinancial('financial-in','financial-out');" value="Entrada">
            </div>
        </form>
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Valor</th>
                    <th>Data do Vencimento</th>
                    <th>Data do Pagamento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="financial-out">
                <?php
                    foreach($financialList as $financial){
                        if($financial->sales != null)
                            continue;
                        echo "<td>";
                        echo $financial->centerCost->nameCenterCost;
                        echo "</td>";

                        echo "<td>";
                        echo $financial->valueProduct;
                        echo "</td>";

                        echo "<td>";
                        if(strtotime($financial->dateDueFinancial) > 0)
                            echo date("d/m/Y", strtotime($financial->dateDueFinancial));
                        echo "</td>";

                        echo "<td>";
                        if(strtotime($financial->datePayFinancial) > 0)
                            echo date("d/m/Y", strtotime($financial->datePayFinancial));
                        echo "</td>";

                        echo "<td>";
                        echo "<a href='SaveOutlay.php?idFinancial=".$financial->idFinancial."' class='btn btn-info btn-sm'>";
                        echo "<span class='glyphicon glyphicon-pencil'></span>"; 
                        echo "</a>";
                        echo "&emsp;";
                        echo "<a onClick='deleteRegister(".$financial->idFinancial.", &quot;Financial&quot;);' class='btn btn-danger btn-sm'>";
                        echo "<span class='glyphicon glyphicon-trash'></span>";
                        echo "</a>";
                        echo "</td>";
                      
                        echo "</tr>";
                        
                    }
                       
                ?>
                
            </tbody>
            <tbody id="financial-in">
                <?php
                    foreach($financialList as $financial){
                        if($financial->sales == null)
                            continue;
                        echo "<td>";
                        echo $financial->description;
                        echo "</td>";

                        echo "<td>";
                        echo $financial->valueProduct;
                        echo "</td>";

                        echo "<td>";
                        if(strtotime($financial->dateDueFinancial) > 0)
                            echo date("d/m/Y", strtotime($financial->dateDueFinancial));
                        echo "</td>";

                        echo "<td>";
                        if(strtotime($financial->datePayFinancial) > 0)
                            echo date("d/m/Y", strtotime($financial->datePayFinancial));
                        echo "</td>";

                        echo "<td>";
                        echo "<a href='SaveOutlay.php?idFinancial=".$financial->idFinancial."' class='btn btn-info btn-sm'>";
                        echo "<span class='glyphicon glyphicon-pencil'></span>"; 
                        echo "</a>";
                        echo "&emsp;";
                        echo "<a onClick='deleteRegister(".$financial->idFinancial.", &quot;Financial&quot;);' class='btn btn-danger btn-sm'>";
                        echo "<span class='glyphicon glyphicon-trash'></span>";
                        echo "</a>";
                        echo "</td>";
                      
                        echo "</tr>";
                        
                    }
                       
                ?>
                
            </tbody>
        </table>
       
    </body>
</html>