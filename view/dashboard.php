<?php
$path = $_SERVER['DOCUMENT_ROOT'];
include_once $path."/bichoensaboado/view/inc/util.php";
include_once $path . "/bichoensaboado/dao/CategoryExpenseFinancialDAO.php";
include_once $path . "/bichoensaboado/dao/ReportDAO.php";
$categoryExpenseDao = new CategoryExpenseFinancialDAO();
$categoryExpenseList = $categoryExpenseDao->searchAll();
$reportDao = new ReportDAO();
$debtorsList = $reportDao->reportDebtors();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <?php
            include_once $path . "/bichoensaboado/view/inc/cssHeader.php";
        ?>
        <title>Bicho Ensaboado</title>
    </head>
    <body>
        <div class="jumbotron">
            <h2>Bicho Ensaboado</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>

        <div class="row main">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 main-left">
                <div class="main-left-debtors">
                    <div class="main-left-debtors-header">
                        <h3>
                            <strong>BlackList</strong>
                        </h3>
                    </div>

                    <div class="main-left-debtors-content">
                        <?php
                            if(empty($debtorsList)){
                                echo '<h3><i class="fa fa-check-circle color-danger" aria-hidden="true"></i> Nenhum Cliente Inadimplente</h3>';
                            }
                        ?>
                        <table class="table">
                            <tbody>
                                <?php foreach ($debtorsList as $debtor) { ?>
                                    <tr>
                                        <td><?=$debtor->column2Report.'/'.$debtor->column1Report ?></td>
                                        <td><?=$debtor->column3Report ?></td>
                                        <td>R$ <?=$debtor->column4Report ?></td>
                                        <td><?=dateUs2Br($debtor->column6Report)?></td>
                                        <td><a href="sales/CashDesk.php?diary=<?=$debtor->column5Report?>" class="btn btn-warning btn-xs"><i class="fa fa-check" aria-hidden="true"></i> Pagar</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 main-right">
                <div class="main-right-start-cashdesk">
                    <div class="main-right-start-cashdesk-header">
                        <h3>
                            <strong>Caixa Inicial</strong>
                            <span class="space-horizontal" id="valueStartingMoney"></span>
                        </h3>
                    </div>

                    <div class="main-right-buttons">
                        <button type="button" id="btnOpenCashdesk" class="btn btn-success">Abrir Caixa</button>
                        <button type="button" id="btnRectify" class="btn btn-danger">Corrigir</button>
                    </div>

                    <div class="main-right-start-cashdesk-form hide">
                        <form id="form-update" action="../controller/Manager.php" method="POST">
                            <input type="hidden" name="module" value="financialPDV-dashboard">

                            <div class="">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="value">Valor Correto:</label>
                                            <input type="text" id="value" name="value" class="form-control" required>
                                            <input type="hidden" id="valueStartingMoney" name="valueStartingMoney" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="justification">Justificativa</label>
                                            <textarea name="justification" id="justification" cols="30" rows="5" class="form-control" required></textarea>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                                        <div class="form-group pull-right">
                                            <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#modalCanc'><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal de senha -->
        <div class="modal fade" id="modalCanc" role="dialog">
            <div class="modal-dialog">
                    
                <!-- Modal content-->
                <div class="modal-content" style="width: 50%;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Corrigir caixa inicial</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row"> <!--div line password-->
                            <div class="col-xs-10 col-sm-10 col-lg-10 col-md-10"> <!--div password-->
                                <div class="form-group"> 
                                    <label for="password">Senha</label>
                                    <input type="password" id="password" name="password" class="form-control" value>
                                    <input type="hidden" id="idCanc" name="idCanc" class="form-control" value>
                                </div>
                            </div> <!-- end div password-->
                        </div><!-- end div line password-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" onClick="confirmRectify();">Confirmar</button>                        
                    </div>
                </div>
                
            </div>
        </div>
        <!--Fim Modal de senha-->
    </body>
</html>
<?php
    include_once $path . "/bichoensaboado/view/inc/jsHeader.php";
?>
<style>
    .main{
        width: 100%;
    }
    .main-left{
        background-color: #000;
    }
    .main-left-debtors-header > h3 strong{
        color: #ff0000;
        margin: 15px;
    }
    .main-left-debtors-content{
        margin-left: 10px;
    }
    .main-left-debtors-content h3{
        color: #fff;
    }
    .main-left-debtors-content h3 i{
        color: #5cb85c;
    }
    .main-left-debtors-content > table{
        background-color: #fff;
    }
    .main-right{
        background-color: #f1efef;
    }
    .main-right-start-cashdesk-header > h3 #valueStartingMoney{
        padding-left: 2em;
        color: #1d7d1c;
    }
    .main-right-buttons{
        margin-top: 40px;
        margin-bottom: 40px;
    }
</style>

<script>
    function confirmRectify(){
        var password = document.getElementById('password').value; 
        if(password == '4518' || password == 'admin1996'){
            if($('#justification').val() == "" ){
                $('#justification').on('focus', alert('Campo Justificativa deve ser preenchido'));
            }else if($('#value').val() == ""){
                $('#value').focus(alert('Campo Valor deve ser preenchido'));
            }else{
                $('#form-update').submit();
            }
        }else{
            alert('Senha Incorreta!');
        }
        
    }
    $(document).ready(function(){

        $.get( "ajax/managerCashDesk.php").done(function( data ) {
            data = JSON.parse(data);

            $('#valueStartingMoney').text('R$ '+data.startingMoney);
            $('input[name=valueStartingMoney]').val(data.startingMoney);
            if(data.isOpen == 0){
                $('#btnOpenCashdesk').text('Caixa Aberto');
                $('#btnOpenCashdesk').attr('disabled', true);
                $('#btnRectify').attr('disabled', true);
            }

        });
               
    });

    $('#btnRectify').on('click', function(){
        $('.main-right-start-cashdesk-form').addClass('show');
        $('.main-right-start-cashdesk-form').removeClass('hide');
    });

    
    $('#btnOpenCashdesk').on('click', function(){
        $.get( "ajax/treasurer.php", {
            option: 1
        }).done(function(data){
            if(data.search("Caixa aberto!") > -1){
                location.href = "index.php?date=<?=date('Y-m-d')?>";
            }else{
                alert('Ocorreu um erro!');
                window.reload();
            }
            
        });
    });



    function selectTitleExpense(idCategory, idCenterCost = 0){
        $.get( "ajax/selectTitleExpense.php", {
            idCategory: idCategory
        }).done(function( data ) {
            data = JSON.parse(data);
            var html = '';
            var optionSelected = '';
            for(var obj in data){
                optionSelected = (data[obj].idCenterCost == idCenterCost ? 'selected' : '');
                html = html.concat('<option value="'+ data[obj].idCenterCost +'" '+optionSelected+'>'+ data[obj].nameCenterCost +'</option>');
            }
            $('#centerCost').html(html);

        });
    }
</script>