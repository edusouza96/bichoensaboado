<?php
    // error_reporting(0);    
    $path = $_SERVER['DOCUMENT_ROOT']; 
    // $search = $_POST['search'];
    include_once($path."/bichoensaboado/dao/CenterCostDAO.php");
    $centerCostDao = new CenterCostDAO();
    if(!empty($search)){
        $centerCostList = $centerCostDao->addWhere(" nameCenterCost LIKE '%".$search."%' ");
    }
    $centerCostList = $centerCostDao->searchAll();

    $version = rand(100, 500);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Lista de Centro de Custo</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=$version?>">
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Centro de Custo</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <a href="save.php" class='btn btn-success btn-sm'style=" float: right;">
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
                    <th>Titulo</th>
                    <th>Categoria</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($centerCostList as $centerCost){
                        echo "<tr id='row".$centerCost->idCenterCost."'>";
                        echo "<td>";
                        echo $centerCost->nameCenterCost;
                        echo "</td>";

                        echo "<td>";
                        echo $centerCost->categoryExpenseFinancial->descCategoryExpenseFinancial;
                        echo "</td>";

                        echo "<td>";
                        echo "<a href='save.php?idCenterCost=".$centerCost->idCenterCost."' class='btn btn-info btn-sm'>";
                        echo "<span class='glyphicon glyphicon-pencil'></span>"; 
                        echo "</a>";
                        echo "&emsp;";
                        echo "<a onClick='deleteRegister(".$centerCost->idCenterCost.", &quot;centerCost&quot;);' class='btn btn-danger btn-sm'>";
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
        