<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once($path."/bichoensaboado/dao/ReportDAO.php");
    $reportDao = new ReportDAO();
    $reportDayMovementList = $reportDao->reportDayMovement();
    $inCash = 0;
    $credit = 0;
    $debit = 0;
    $expenseBankOnline = 0;
    $expenseSavings = 0;
    $expenseDrawer = 0;
    $expenseBank = 0;
    foreach($reportDayMovementList as $report){
        if($report->column3Report == 1){
            $inCash = $report->column1Report;
        }else if($report->column3Report == 2){
            $debit = $report->column1Report;
        }else if($report->column3Report == 3){
            $credit = $report->column1Report;
        }else{
            if($report->column4Report == 1){
                $expenseDrawer = $report->column1Report;
            }else if($report->column4Report == 2){
                $expenseSavings = $report->column1Report;
            }else if($report->column4Report == 3){
                $expenseBankOnline = $report->column1Report;
            }else if($report->column4Report == 4){
                $expenseBank = $report->column1Report;
            }
        }
    }
    include_once($path."/bichoensaboado/dao/TreasurerDAO.php");
    $treasurerDao = new TreasurerDAO();
    $treasurerClass = $treasurerDao->searchLastId();
?>
<div class="modal fade" id="dayMovement" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 60%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Movimentação do Dia</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-10 col-sm-10 col-lg-10 col-md-10">
                        <div class="form-group">
                            <h3>Caixa Inicial</h3>
                            <h5>R$ <?=$treasurerClass->startingMoneyDayTreasurer?></h5>

                            <h3>Valores Arrecadados</h3>
                            <h5>Dinheiro R$ <?=$inCash?></h5>
                            <h5>Cartão de Débito R$ <?=$credit?></h5>
                            <h5>Cartão de Crédito R$ <?=$debit?></h5>

                            <h3>Valores Retirado</h3>
                            <h5>Caixa R$ <?=$expenseDrawer?></h5>
                            <h5>Cofre R$ <?=$expenseSavings?></h5>
                            <h5>Banco R$ <?=$expenseBank?></h5>
                            <h5>PagSeguro R$ <?=$expenseBankOnline?></h5>

                            <h3>Total no Caixa R$ <?=$treasurerClass->startingMoneyDayTreasurer+$inCash-$expenseDrawer?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>