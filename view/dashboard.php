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
                            <input type="hidden" name="typeTreasurerFinancial" value="1">

                            <div class="">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="categoryExpenseFinancial">Categoria da despesa:</label>
                                            <select id="categoryExpenseFinancial" name="categoryExpenseFinancial" class="form-control" onChange="selectTitleExpense(this.value);" required>
                                                <option value="">-- Selecione --</option>
                                                    <?php
                                                        // $idCenterCost = $financial->centerCost->idCenterCost;
                                                        foreach ($categoryExpenseList as $categoryExpense) {
                                                            $idOption = $categoryExpense->idCategoryExpenseFinancial;
                                                            $descOption = $categoryExpense->descCategoryExpenseFinancial;
                                                            echo '<option value="' . $idOption . '" >' . $descOption . '</option>';
                                                        }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <label for="centerCost">Titulo</label>
                                            <select id="centerCost" name="centerCost" class="form-control" required>
                                                <option value="">-- Selecione uma categoria acima --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="dateDueFinancial">Data de Vencimento</label>
                                            <input type="date" id="dateDueFinancial" name="dateDueFinancial" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="datePayFinancial">Data de Pagamento</label>
                                            <input type="date" id="datePayFinancial" name="datePayFinancial" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <label for="valueProduct">Custo do gasto</label>
                                            <input type="text" id="valueProduct" name="valueProduct" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                                        <div class="form-group pull-right">
                                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
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
    $(document).ready(function(){

        $.get( "ajax/managerCashDesk.php").done(function( data ) {
            data = JSON.parse(data);

            $('#valueStartingMoney').text('R$ '+data.startingMoney);
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
            if(data == "  Caixa aberto!"){
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