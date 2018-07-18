<?php
    error_reporting(0);
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/RebateDAO.php");
    $rebateDao = new RebateDAO();
    $search = $_POST['search'];
    if(!empty($search)){
        $rebateList = $rebateDao->addWhere(" descriptionRebate LIKE '%".$search."%' ");
    }
    $rebateList = $rebateDao->searchAll();

    $version = rand(100, 500);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Lista de Descontos</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=$version?>">
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Descontos</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <a href="save.php" class='btn btn-success btn-sm'style="margin-top: -5.5%;float: right;">
            <span class='glyphicon glyphicon-plus'></span> Adicionar
        </a>
        <form role="form" method="POST">
            <div class="form-group col-xs-12 col-sm-12 col-lg-4 col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchBar" name="search" placeholder="Buscar" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info" value="Buscar">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>
        </form>
        <table border="1" id="tableList" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($rebateList as $rebate){
                        echo "<tr id='row".$rebate->idRebate."'>";
                        echo "<td>";
                        echo $rebate->descriptionRebate;
                        echo "</td>";

                        echo "<td>";
                        echo $rebate->valueRebate;
                        echo "</td>";

                        echo "<td>";
                        echo ($rebate->active ? 'Ativo' : 'Inativo');
                        echo "</td>";

                        echo "<td>";
                        echo "<a href='save.php?idRebate=".$rebate->idRebate."' class='btn btn-info btn-sm'>";
                        echo "<span class='glyphicon glyphicon-pencil'></span>"; 
                        echo "</a>";
                        echo "&emsp;";
                        echo "<a onClick='deleteRegister(".$rebate->idRebate.", &quot;rebate&quot;);' class='btn btn-danger btn-sm'>";
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
<script language="javascript" src="../../js/ajax.js?v=<?=$version?>"></script>
<script language="javascript" src="../../js/functionsModules.js?v=<?=$version?>"></script>
        