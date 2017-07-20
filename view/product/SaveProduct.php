<?php
    
    if(empty($_GET['idProduct'])){
        $idProduct = '';
    }else{
        $idProduct = $_GET['idProduct'];
    }
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/ProductDAO.php");
    $productDao = new ProductDAO();
    $product = $productDao->SearchId($idProduct);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <title>Cadastro de Produtos</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
    </head>
    <body>
        <div class="jumbotron">
            <h2>Produtos</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        
        <form action="../../controller/Manager.php" method="POST">
            <input type="hidden" name="module" value="product"> 
            <input type="hidden" name="idProduct" value="<?=$idProduct?>" > 
            <div class="container">
                <div class="row"> <!--div line product-->
                    <div class="col-xs-7 col-sm-7 col-lg-7 col-md-7"> <!--div product-->
                        <div class="form-group"> 
                            <label for="nameProduct">Nome do Produto</label>
                            <input type="text" id="nameProduct" name="nameProduct" class="form-control" value="<?=$product->nameProduct?>" required>
                        </div>
                    </div> <!-- end div product-->
                </div><!-- end div line product-->

                <div class="row"> <!--div line Valuation AND quantity-->
                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"> <!--div Valuation Buy-->
                        <div class="form-group"> 
                            <label for="valuationBuyProduct">Valor Unidade de Compra</label>
                            <input type="text" id="valuationBuyProduct" name="valuationBuyProduct" class="form-control" value="<?=$product->valuationBuyProduct?>" required>
                        </div>
                    </div> <!-- end div Valuation Buy-->

                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"> <!--div Valuation Sale-->
                        <div class="form-group"> 
                            <label for="valuationProduct">Valor Unidade de Venda</label>
                            <input type="text" id="valuationProduct" name="valuationProduct" class="form-control" value="<?=$product->valuationProduct?>" required>
                        </div>
                    </div> <!-- end div Valuation Sale-->

                    <div class="col-xs-1 col-sm-1 col-lg-1 col-md-1"> <!--div quantity-->
                        <div class="form-group"> 
                            <label for="quantityProduct">Quantidade</label>
                            <input type="text" id="quantityProduct" name="quantityProduct" class="form-control" value="<?=$product->quantityProduct?>">
                        </div>
                    </div> <!-- end div quantity-->
                </div><!-- end div line Valuation AND quantity-->

                <div class="row"> <!--div button-->
                    <div class="col-xs-8 col-sm-8 col-lg-8 col-md-82">
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Salvar</button>
                        </div>
                    </div>
                </div><!-- end div button-->

            </div>
            
        </form>
    </body>
</html>
