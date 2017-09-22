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
        <script language="javascript" src="../../js/ajax.js?v=<?=rand(100, 500)?>"></script>
        <script language="javascript" src="../../js/functionsModules.js?v=<?=rand(100, 500)?>"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
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
            <input type="hidden" name="idProduct" id="idProduct" value="<?=$idProduct?>" > 
            <div class="container">
                <div class="row"> <!--div line barcode product-->
                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"> <!--div barcode product-->
                        <div class="form-group"> 
                            <label for="barcodeProduct">Código de barra</label>
                            <input type="text" id="barcodeProduct" name="barcodeProduct" class="form-control" value="<?=$product->barcodeProduct?>" required>
                        </div>
                    </div> <!-- end div barcode product-->
                </div><!-- end div line barcode product-->

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
                            <input type="button" onclick="alertValuationExpected();" class="btn btn-default" value="Salvar">
                        </div>
                    </div>
                </div><!-- end div button-->

            </div>
            <?php
                include_once('dialogProduct.php');
            ?>
        </form>
    </body>
</html>
