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
        <meta charset="UTF-8">
        <title>Cadastro de Produtos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php
            include_once($path."/bichoensaboado/view/inc/cssHeader.php");
        ?>
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
                <div class="row"> <!--div line product-->
                    <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6"> <!--div product-->
                        <div class="form-group"> 
                            <label for="nameProduct">Nome do Produto</label>
                            <input type="text" id="nameProduct" name="nameProduct" class="form-control" value="<?=$product->nameProduct?>" required>
                        </div>
                    </div> <!-- end div product-->
                </div><!-- end div line product-->

                <div class="row"> <!--div line barcode product-->
                    <div class="col-xs-12 col-sm-12 col-lg-4 col-md-4"> <!--div barcode product-->
                        <div class="form-group"> 
                            <label for="barcodeProduct">Código de barra</label>
                            <input type="text" id="barcodeProduct" name="barcodeProduct" class="form-control" value="<?=$product->barcodeProduct?>" required>
                        </div>
                    </div> <!-- end div barcode product-->

                     <div class="col-xs-12 col-sm-12 col-lg-2 col-md-2"> <!--div quantity-->
                        <div class="form-group"> 
                            <label for="quantityProduct">Quantidade</label>
                            <input type="text" id="quantityProduct" name="quantityProduct" class="form-control" value="<?=$product->quantityProduct?>">
                        </div>
                    </div> <!-- end div quantity-->

                </div><!-- end div line barcode product-->

                <div class="row"> <!--div line Valuation AND quantity-->
                    <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3"> <!--div Valuation Buy-->
                        <div class="form-group"> 
                            <label for="valuationBuyProduct">Valor Unidade de Compra</label>
                            <input type="text" id="valuationBuyProduct" name="valuationBuyProduct" class="form-control" value="<?=$product->valuationBuyProduct?>" required>
                        </div>
                    </div> <!-- end div Valuation Buy-->

                    <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3"> <!--div Valuation Sale-->
                        <div class="form-group"> 
                            <label for="valuationProduct">Valor Unidade de Venda</label>
                            <input type="text" id="valuationProduct" name="valuationProduct" class="form-control" value="<?=$product->valuationProduct?>" required>
                        </div>
                    </div> <!-- end div Valuation Sale-->

                </div><!-- end div line Valuation AND quantity-->

                <div class="row"> <!--div button-->
                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
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
<?php
    include_once($path."/bichoensaboado/view/inc/jsHeader.php");
?>