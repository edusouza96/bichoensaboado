<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/ProductDAO.php");
    $productDao = new ProductDAO();
    $productList = $productDao->searchAll();
    $productJson = "";
    foreach ($productList as $product){
        $f_list[] = array('label' => utf8_encode($product->nameProduct));
        $productJson .= ($product->serialize()).",";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <title>Caixa</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
        
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
        <script>

            function completeProduct(){
                $(".searchProduct").autocomplete({
                    source: <?php
                                echo json_encode($f_list);
                            ?>
                });
            }    

            function completeFieldValueTotalCashDesk(){
                $valueUnit = $("#valueItems").val();
                $numberItens = $("#numberItems").val();
                if($numberItens == 0 || $numberItens == '' || $numberItens == undefined){
                    $numberItens = 1;
                }
                if($valueUnit == 0 || $valueUnit == '' || $numberItens == 'valueUnit'){
                    $valueUnit = 0;
                }
                $("#valueTotalItems").val(int2decimal(parseFloat($valueUnit) * parseInt($numberItens)));
            } 

            function int2decimal(value){
                return value.toFixed(2);
            }

            function completeFieldValueCashDesk(value){
                var listProducts = <?php
                                        echo '['.$productJson.']';
                                    ?>;
                for(cont in listProducts){
                    if(listProducts[cont].nameProduct == value){
                        $("#valueItems").val(int2decimal(parseFloat(listProducts[cont].valuationProduct)));   
                        completeFieldValueTotalCashDesk();
                    }
                }
            }

            function sendRegisterBuy(){
                var productName = $("#searchProduct").val().split("#");
                if(productName[1] != undefined){
                    if($("#numberItems").val() <2){
                        $("#numberItems").val(1);
                    }
                    var div = '<div class="form-group" style="margin-bottom: 0px;display:-webkit-box;">'; 
                    div +=    '     <p class="col-xs-2 col-sm-2 col-lg-2 col-md-2">'+ $("#numberItems").val() +'</p>';
                    div +=    '     <p class="col-xs-4 col-sm-4 col-lg-4 col-md-4">'+ productName[1] +'</p>';
                    div +=    '     <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3">'+ $("#valueItems").val() +'</p>';
                    div +=    '     <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3">'+ $("#valueTotalItems").val() +'</p>';
                    div +=    '</div>';
                    div +=    '<input type="hidden" name="quantityProductSales[]" value="'+ $("#numberItems").val() +'">';
                    div +=    '<input type="hidden" name="productSales[]" value="'+ productName[0] +'">';
                    div +=    '<input type="hidden" name="valuationUnitSales[]" value="'+ $("#valueItems").val() +'">';
                    var divRegisterBuy = $("#listRegisterBuy").html();
                    divRegisterBuy += div;
                    $("#listRegisterBuy").html(divRegisterBuy);
                    var gross = $("#subTotal").text();
                    gross = gross.substring(3);
                    var grossProduct = $("#valueTotalItems").val();
                    gross = parseFloat(gross)+parseFloat(grossProduct);
                    $("#subTotal").text("R$ "+int2decimal(gross));
                }
            }
            
            
        </script>
    </head>
    <body>
        <div class="jumbotron">
            <h2>Caixa</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <form action="../../controller/Manager.php" method="POST">
            <input type="hidden" name="module" value="sales"> 
            <input type="hidden" name="idSales" value="0" >
            
            <div class="container">
                <div class="row"> 
                    
                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                        <div class="form-group" style="background:#fff;height: 50px;"> 
                            <center>
                                <input type="text" name="searchProduct" id="searchProduct" onChange='completeFieldValueCashDesk(this.value);' onKeyPress='completeProduct();' class="form-control searchProduct" style="height: 100%;width: 98%;font-size: 34px;">
                            </center>
                        </div>
                    </div>
                            
                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                        <div style="background: #fff;height: 200px;">
                            <div class="form-group" style="background: #fff;height: 50px;display:-webkit-box;font-size: 24px;"> 
                                Valor unitario<input type="text" name="valueItems" id="valueItems" class="form-control" style="margin-right:15%;height: 100%;width:30%;font-size: 24px;" readonly="readonly">
                                Qtde<input type="text" name="numberItems" id="numberItems" onChange="completeFieldValueTotalCashDesk();" maxlenght="4" class="form-control" style="height: 100%;width:15%;font-size: 24px;">
                            </div>

                            <div class="form-group" style="background: #fff;height: 50px;display:-webkit-box;font-size: 24px;"> 
                                Total Produto<input type="text" name="valueTotalItems" id="valueTotalItems" class="form-control" style="height: 100%;width:30%;font-size: 24px;" readonly="readonly">
                            </div>

                            <div class="form-group" style="background: #fff;height: 50px;display:-webkit-box;font-size: 24px;"> 
                                <input  onclick="sendRegisterBuy();" type="reset" value="Registrar" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                        <div id="listRegisterBuy" style="background: #fbf4b4;min-height: 200px;">
                            
                            <div class="form-group" style="background: #fbf4b4;height: 50px;display:-webkit-box;font-size: 18px;font-weight: bold;"> 
                                <p class="col-xs-2 col-sm-2 col-lg-2 col-md-2">Qtde</p>
                                <p class="col-xs-4 col-sm-4 col-lg-4 col-md-4">Item</p>
                                <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3">Valor unitario</p>
                                <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3">Total do produto</p>
                            </div>
                           
                            
                        </div>
                        <div class="form-group" style="background: #47d21e;height: 30px;">
                            <h4 style="float: left;">Sub-Total</h4>
                            <h4 id="subTotal" style="float: right;">R$ 00.00</h4>
                        </div>
                        <div class="form-group" style="height: 30px;">
                            <input type="submit" value="Finalizar" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>