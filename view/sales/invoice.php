<style>
    .span-invoice{
        display: inline-block;
        width: 100;
    }
    .div-separator{
        border: 1px solid black;
        width: 600px;
        margin-top: 30px;
    }
    .footer{
        position:absolute;
        bottom:0;
        width:100%;
    }
    @media print { 
        #noprint { display:none; } 
        body { background: #fff; }
    }
</style>
<link rel="stylesheet" href="../css/bootstrap-3.3.7-dist/css/bootstrap.css">
<?php
    echo "<div>Bicho Ensaboado PetShop</div>";
    echo "<div>Operarios, 84 Centro Viam�o/RS CEP:94410-090</div>";
    echo "<div>Tel: (51)3045-1898</div>";
    echo "<div>CNPJ:14.524.569/0001-60";
    echo "<div class='div-separator'></div>";
    echo "<div>Venda ".$registerBuy."</div>";
    echo "<div class='div-separator'></div>";
    echo "<div>
            <span class='span-invoice'>#</span>
            <span class='span-invoice'>C�digo</span>
            <span class='span-invoice'>Descri��o</span>
            <span class='span-invoice'>Quantidade</span>
            <span class='span-invoice'>Valor unit�rio</span>
            <span class='span-invoice'>Valor total</span>
        </div>";
    $total = 0;
    $diarySalesId = 0;
    for($i=0; $i<count($valuationUnitSales); $i++){  
        $productSalesId = $productSales[$i];
        $productSalesName = '';
        $productAuxDao = new ProductDAO();
        $diaryAuxDao = new DiaryDAO();
        if($productSalesId>0){
            $productAuxClass = $productAuxDao->searchId((int) $productSalesId);
            $productSalesName = explode('#', $productAuxClass->nameProduct);
            $productSalesName = $productSalesName[1];
        }else{
            $diarySalesId = $diarySales[$i];
            $diaryAuxClass = $diaryAuxDao->searchId((int) $diarySalesId);
            $productSalesName = $diaryAuxClass->servic->nameServic;
            $productSalesId = $diaryAuxClass->servic->idServic;
        }
        echo "<div>
                <span class='span-invoice'>".($i+1)."</span>
                <span class='span-invoice'>".$productSalesId."</span>
                <span class='span-invoice'>".$productSalesName."</span>
                <span class='span-invoice'>".$quantityProductSales[$i]."</span>
                <span class='span-invoice'>".$valuationUnitSales[$i]."</span>
                <span class='span-invoice'>".($quantityProductSales[$i] * $valuationUnitSales[$i])."</span>
            </div>";
        $total += ($quantityProductSales[$i] * $valuationUnitSales[$i]);
    }
    echo "<div class='div-separator'></div>";
    echo "<div>Valor Total R$ ".$total."</div>";
    // echo "<div>Forma de pagamento</div>";
    if($diarySalesId>0){
        echo "<div class='div-separator'></div>";
        echo "<div>Consumidor</div>";
        // echo "<div>CPF: 861.755.560-20</div>";
        echo "<div>".$diaryAuxClass->client->owner."</div>";
    }
?>
<div id="noprint" class="footer"> <!--div button-->
    <div class="col-xs-8 col-sm-8 col-lg-8 col-md-82">
        <div class="form-group">
            <button class="btn btn-primary glyphicon glyphicon-calendar" onclick="location.href = '/bichoensaboado/Calendar/';"> Agenda</button>
            <button class="btn btn-primary glyphicon glyphicon-usd" onclick="location.href = '/bichoensaboado/view/sales/';"> Caixa</button>
            <button class="btn btn-primary glyphicon glyphicon-print" onclick="window.print();"> Imprimir</button>
        </div>
    </div>
</div><!-- end div button-->
<?php
exit;