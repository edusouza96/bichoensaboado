<?php
    
    error_reporting(0);    
    $path = $_SERVER['DOCUMENT_ROOT']; 
    $search = $_POST['search'];
    include_once($path."/bichoensaboado/dao/ProductDAO.php");
    $productDao = new ProductDAO();
    if(empty($search)){
        $productDao->addWhere("quantityProduct > 0 ");
        $productList = $productDao->searchAll();
    }else{
        $productDao->addWhere("nameProduct LIKE '%".$search."%' ");
        $productList = $productDao->searchAll();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Lista de Produtos</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <script language="javascript" src="../../js/ajax.js?v=2"></script>
        <script language="javascript" src="../../js/functionsModules.js?v=2"></script>
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Produtos</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <a href="SaveProduct.php" class='btn btn-success btn-sm'style=" float: right;">
            <span class='glyphicon glyphicon-plus'></span> Adicionar
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
            </div>
        </form>
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Valor de Compra</th>
                    <th>Valor de Venda</th>
                    <th>Quantidade</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($productList as $product){
                        echo "<td>";
                        echo $product->nameProduct;
                        echo "</td>";

                        echo "<td>";
                        echo $product->valuationBuyProduct;
                        echo "</td>";

                        echo "<td>";
                        echo $product->valuationProduct;
                        echo "</td>";

                        echo "<td>";
                        echo $product->quantityProduct;
                        echo "</td>";

                        echo "<td>";
                        echo "<a href='SaveProduct.php?idProduct=".$product->idProduct."' class='btn btn-info btn-sm'>";
                        echo "<span class='glyphicon glyphicon-pencil'></span>"; 
                        echo "</a>";
                        echo "&emsp;";
                        echo "<a onClick='deleteRegister(".$product->idProduct.", &quot;Product&quot;);' class='btn btn-danger btn-sm'>";
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