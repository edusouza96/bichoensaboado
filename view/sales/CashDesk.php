<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/DiaryDAO.php");
    include_once($path."/bichoensaboado/dao/VetDAO.php");
    include_once($path."/bichoensaboado/dao/ProductDAO.php");
    include_once($path."/bichoensaboado/dao/SalesDAO.php");
    include_once($path."/bichoensaboado/dao/RebateDAO.php");
    $productDao = new ProductDAO();
    $productList = $productDao->searchAll();
    $productJson = "";
    $productArray = array();
    foreach ($productList as $product){
        $f_list[] = array('value' => $product->barcodeProduct, 'label' => ($product->nameProduct));
        $productArray[] = array('barcodeProduct'=> $product->barcodeProduct, 'valuationProduct' => $product->valuationProduct);
    }
    $productJson = json_encode($productArray);
    $subValue = 'R$ 00.00';

    $rebateDao = new RebateDAO();
    $rebateList = $rebateDao->searchAll();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <title>Caixa</title>
        <link rel="icon" href="../../img/logo.jpg" type="image/png" />
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="stylesheet" href="../../css/jquery-ui.min.css" type="text/css" /> 
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
        <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.min.css">
        
    </head>
    <body>
        <div class="jumbotron">
            <h2>PDV</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
            include_once($path."/bichoensaboado/view/financial/confirmStartingMoney.php");
        ?>

        <form action="../../controller/Manager.php" method="POST">
            <input type="hidden" name="module" value="sales"> 
            <input type="hidden" name="idSales" value="0" >
            
            <div class="container">
                <div class="row"> 
                    
                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                        <div class="form-group" style="background:#fff;height: 50px;"> 
                            <center>
                                <input data-id type="text" name="searchProduct" id="searchProduct" onChange='completeFieldValueCashDesk(this.value);' onKeyPress='completeProduct();' class="form-control searchProduct" style="height: 100%;width: 98%;font-size: 34px;">
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
                                <input onclick="sendRegisterBuy();" type="button" value="Registrar" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                        <div id="listRegisterBuy" style="background: #fbf4b4;min-height: 200px;">
                            
                            <div class="form-group" style="background: #fbf4b4;height: 50px;display:block;font-size: 18px;font-weight: bold;"> 
                                <p class="col-xs-2 col-sm-2 col-lg-2 col-md-2">Qtde</p>
                                <p class="col-xs-4 col-sm-4 col-lg-4 col-md-4">Item</p>
                                <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3">Valor unitario</p>
                                <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3">Total do produto</p>
                            </div>
                            <?php
                            if(!empty($_GET['diary'])){
                                $diaryId = $_GET['diary'];

                                $salesDao = new SalesDAO();
                                $salesDao->addWhere(' diary_idDiary = '.$diaryId);
                                $salesList = $salesDao->searchAll();
                                if(count($salesList) < 1){
                                    $diaryDao = new DiaryDAO();   
                                    $diaryDao->addWhere("OR","idDiary = ".$diaryId." ");   
                                    $diaryList = $diaryDao->SearchCompanion($diaryId);  
                                    $subValue = 0;
                                    $valueService = 0;
                                    foreach($diaryList as $diaryClass){   
                                        $valueService += $diaryClass->price();
                            ?>
                                <div class="form-group" style="margin-bottom: 0px;display:block;height: 60px;">
                                    <p class="col-xs-2 col-sm-2 col-lg-2 col-md-2">1</p>
                                    <p class="col-xs-4 col-sm-4 col-lg-4 col-md-4"><?=$diaryClass->servic->nameServic?>/<?=$diaryClass->servicVet->nameServic?></p>
                                    <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3"><?=$diaryClass->price()?></p>
                                    <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3"><?=$diaryClass->price()?></p>
                                </div>
                                <input type="hidden" name="quantityProductSales[]" value="1">
                                <input type="hidden" name="diarySales[]" value="<?=$diaryClass->idDiary?>">
                                <input type="hidden" name="productSales[]" value="0">
                                <input type="hidden" name="valuationUnitSales[]" value="<?=$diaryClass->price()?>">
                                        
                                <?php
                                    if($diaryClass->valueSearch() > 0){
                                ?>
                                    <div class="form-group" style="margin-bottom: 0px;display:block;height: 60px;">
                                        <p class="col-xs-2 col-sm-2 col-lg-2 col-md-2">1</p>
                                        <p class="col-xs-4 col-sm-4 col-lg-4 col-md-4">Busca</p>
                                        <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3"><?=$diaryClass->valueSearch()?></p>
                                        <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3"><?=$diaryClass->valueSearch()?></p>
                                    </div>
                                    <input type="hidden" name="quantityProductSales[]" value="1">
                                    <input type="hidden" name="diarySales[]" value="<?=$diaryClass->idDiary?>">
                                    <input type="hidden" name="productSales[]" value="0">
                                    <input type="hidden" name="valuationUnitSales[]" value="<?=$diaryClass->valueSearch()?>">
                               
                            <?php
                                    }
                                    $subValue += $diaryClass->price() + $diaryClass->valueSearch();
                                }
                            ?> 
                            <input type="hidden" name="valueService" id="valueService" value="<?=$valueService?>">
                                    <script>
                                        window.onload = function() {
                                            diaryRegisterBuy(<?=$subValue?>);
                                        };
                                    </script>
                            <?php
                                    $subValue = 'R$ '.$subValue;
                                }else{
                                    ?>
                                    <script>
                                        window.onload = function() {
                                            document.getElementById('alert').style.display = 'block';
                                            document.getElementById('msg-alert').innerHTML = 'Pagamento já realizado';
                                        };
                                    </script>
                                    <?php
                                }
                            }
                            ?>


                                <!-- VET -->
                            <?php
                            if(!empty($_GET['vet'])){
                                $vetId = $_GET['vet'];

                                $salesDao = new SalesDAO();
                                $salesDao->addWhere(' vet_idVet = '.$vetId);
                                $salesList = $salesDao->searchAll();
                                if(count($salesList) < 1){
                                    $vetDao = new VetDAO();   
                                    $vetDao->addWhere("OR","idVet = ".$vetId." ");   
                                    $vetClass = $vetDao->SearchId($vetId);  
                                    $subValue = 0;
                            ?>
                                <div class="form-group" style="margin-bottom: 0px;display:block;height: 60px;">
                                    <p class="col-xs-2 col-sm-2 col-lg-2 col-md-2">1</p>
                                    <p class="col-xs-4 col-sm-4 col-lg-4 col-md-4"><?=$vetClass->servic->nameServic?></p>
                                    <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3"><?=$vetClass->totalPrice?></p>
                                    <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3"><?=$vetClass->totalPrice?></p>
                                </div>
                                <input type="hidden" name="quantityProductSales[]" value="1">
                                <input type="hidden" name="diarySales[]" value="<?=$vetClass->idVet?>">
                                <input type="hidden" name="productSales[]" value="0">
                                <input type="hidden" name="valuationUnitSales[]" value="<?=$vetClass->totalPrice?>">
                               
                            <?php
                                        $subValue += $vetClass->totalPrice;
                            ?> 
                                    <script>
                                        window.onload = function() {
                                            diaryRegisterBuy(<?=$subValue?>);
                                        };
                                    </script>
                            <?php
                                    $subValue = 'R$ '.$subValue;
                                }else{
                                    ?>
                                    <script>
                                        window.onload = function() {
                                            document.getElementById('alert').style.display = 'block';
                                            document.getElementById('msg-alert').innerHTML = 'Pagamento já realizado';
                                        };
                                    </script>
                                    <?php
                                }
                            }
                            ?>
                            
                        </div>
                        <div class="form-group" style="background: #47d21e;height: 30px;">
                            <h4 style="float: left;">Sub-Total</h4>
                            <h4 id="subTotal" style="float: right;"><?=$subValue?></h4>
                        </div>
                        <div class="col-xs-9 col-sm-9 col-lg-9 col-md-9">
                            <div class="form-group">
                                <label for="methodPayment">Forma de pagamento</label> 
                                <select id="methodPayment" name="methodPayment" class="form-control" onchange="methodPaymentAction(this.value);" required>
                                    <option value="1">À vista</option>
                                    <option value="2">Cartão - Débito</option>
                                    <option value="3">Cartão - Crédito</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3">
                            <div class="form-group">
                                <label for="numberPlotsFinancial">Nº Parcelas</label> 
                                <input type="number" id="numberPlotsFinancial" name="numberPlotsFinancial" class="form-control" min="0" max="9" readonly>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="promotion">Desconto Promocional</label> 
                                <select id="promotion" name="promotion" class="form-control" onblur="calcPromotion(this.value);">
                                    <option>-- Selecione --</option>
                                    <?php
                                        foreach($rebateList as $rebate){
                                            echo "<option value='$rebate->idRebate'>$rebate->descriptionRebate</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="rebate">Desconto</label> 
                                <input type="text" id="rebate" name="rebate" value="0.0" class="form-control" onblur="applyRebate(this.value);">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                            <div class="form-group">
                                <label for="totalBuy">Total</label> 
                                <input type="text" id="totalBuy" name="totalBuy" class="form-control" readonly="readonly" required>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="valueReceive">Valor Recebido</label> 
                                <input type="text" id="valueReceive" name="valueReceive" class="form-control" onblur="calculateValueReceive(this.value);" required>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                            <div class="form-group">
                                <label for="change">Troco</label> 
                                <input type="text" id="change" name="change" class="form-control" readonly="readonly">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                            <div class="form-group" style="height: 30px;">
                                <input type="submit" value="Finalizar" class="form-control" id="btn_submit">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>
<script language="javascript" src="../../js/ajax.js?v=2"></script>
<script language="javascript" src="../../js/jquery.min.js"></script>
<script language="javascript" src="../../js/jquery-1.10.2.js"></script>
<script language="javascript" src="../../js/bootstrap.min.js"></script>
<script language="javascript" src="../../js/jquery-ui.js"></script>
<script>

    function completeProduct(){
        $(".searchProduct").autocomplete({
            source: <?php echo json_encode($f_list); ?>,
            select: function( event, ui ) {
                $( "#searchProduct" ).val( ui.item.label );
                $( "#searchProduct" ).data( "id", ui.item.value );
        
                return false;
            }
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
        var nameProduct = $("#searchProduct").val();
        var barcode = $("#searchProduct").data("id");
        var listProducts = <?php
                                echo $productJson;
                            ?>;
        for(cont in listProducts){
            if(listProducts[cont]['barcodeProduct'] == barcode){
                $("#valueItems").val(int2decimal(parseFloat(listProducts[cont]['valuationProduct'])));   
                completeFieldValueTotalCashDesk();
            }
        }
    }

    function applyRebate(valueRebate){
        var gross = $("#subTotal").text();
        gross = gross.substring(3);
        gross = parseFloat(gross)
        valueRebate = parseFloat(valueRebate);
        $("#totalBuy").val(int2decimal(gross-valueRebate));
        methodPaymentAction($("#methodPayment").val());
    }

    function calculateValueReceive(valueReceive){
        var totalBuy = $("#totalBuy").val();
        totalBuy = parseFloat(totalBuy);
        valueReceive = parseFloat(valueReceive);
        $("#change").val(int2decimal(valueReceive-totalBuy));
    }

    function methodPaymentAction(idMethodPayment){
        if(idMethodPayment == 1){
            $("#valueReceive").removeAttr("readonly");
            $("#numberPlotsFinancial").attr("readonly", "readonly");
        }else if(idMethodPayment == 2){
            $("#change").val("0.0");
            var totalBuy = $("#totalBuy").val();
            $("#valueReceive").val(totalBuy);
            $("#valueReceive").attr("readonly", "readonly");
            $("#numberPlotsFinancial").attr("readonly", "readonly");
        }else{
            $("#change").val("0.0");
            var totalBuy = $("#totalBuy").val();
            $("#valueReceive").val(totalBuy);
            $("#valueReceive").attr("readonly", "readonly");
            $("#numberPlotsFinancial").removeAttr("readonly");
        }
    }

    function diaryRegisterBuy(grossProduct){
        $("#totalBuy").val(int2decimal(parseFloat(grossProduct)));
    }
    function sendRegisterBuy(){
        var productName = $("#searchProduct").val();
        var barcode = $("#searchProduct").data("id");
        if(productName != undefined){
            if($("#numberItems").val() <2){
                $("#numberItems").val(1);
            }
            var div = '<div class="form-group" style="margin-bottom: 0px;display:block;height: 60px;">'; 
            div +=    '     <p class="col-xs-2 col-sm-2 col-lg-2 col-md-2">'+ $("#numberItems").val() +'</p>';
            div +=    '     <p class="col-xs-4 col-sm-4 col-lg-4 col-md-4">'+ productName +'</p>';
            div +=    '     <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3">'+ $("#valueItems").val() +'</p>';
            div +=    '     <p class="col-xs-3 col-sm-3 col-lg-3 col-md-3">'+ $("#valueTotalItems").val() +'</p>';
            div +=    '</div>';
            div +=    '<input type="hidden" name="quantityProductSales[]" value="'+ $("#numberItems").val() +'">';
            div +=    '<input type="hidden" name="productSales[]" value="'+ barcode +'">';
            div +=    '<input type="hidden" name="valuationUnitSales[]" value="'+ $("#valueItems").val() +'">';
            var divRegisterBuy = $("#listRegisterBuy").html();
            divRegisterBuy += div;
            $("#listRegisterBuy").html(divRegisterBuy);
            var gross = $("#subTotal").text();
            gross = gross.substring(3);
            var grossProduct = $("#valueTotalItems").val();
            gross = parseFloat(gross)+parseFloat(grossProduct);
            $("#subTotal").text("R$ "+int2decimal(gross));
            $("#totalBuy").val(int2decimal(gross));

            // reset fields
            $("#searchProduct").val(null);
            $("#valueItems").val(null);
            $("#numberItems").val(null);
            $("#valueTotalItems").val(null);
            $("#rebate").val("0.0");
        }
    }

    function calcPromotion(idRebate) {
        var valueService = $("#valueService").val();
        valueService = parseFloat(valueService);
        if(valueService > 0){
            $.get( "../ajax/getRebate.php", {idRebate : idRebate}).done(function( valueRebate ) {                    
                var rebate = (valueService * valueRebate) /100;
                $('#rebate').val(rebate);
                applyRebate(rebate);
            });  
            
        }
    }

    $(document).keypress(function(e) {
        if(e.which == 13) {
            $('#btn_submit').focus();
            return false;
        }
    });

    $(document).ready(function(){
        $.get( "../ajax/managerCashDesk.php").done(function( data ) {
            data = JSON.parse(data);
            if(data.isClose == 1){
                alert('Ops! Caixa ainda Fechado. \nVocê será redirecionado para confirmar abertura de caixa');
                if('<?=$developer?>' == 0){
                    $(location).attr('href','/bichoensaboado/view/dashboard.php');
                }else{
                    alert('Developer!!!');
                }
            }

        });
   });
    
</script>