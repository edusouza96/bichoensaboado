<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once($path."/bichoensaboado/dao/ReportDAO.php");
    $reportDao = new ReportDAO();
    $reportDayMovementList = $reportDao->reportDayMovement();
    $inCash = 0;
    $debit = 0;
    $credit = 0;
    $expense = 0;
    foreach($reportDayMovementList as $report){
        if($report->column3Report == 1){
            $inCash = $report->column1Report;
        }else if($report->column3Report == 2){
            $debit = $report->column1Report;
        }else if($report->column3Report == 3){
            $credit = $report->column1Report;
        }else{
            $expense = $report->column1Report;
        }
    }
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
                            <h3>Entrada</h3>
                            <h5>Valor em Dinheiro R$ <?=$inCash?></h5>
                            <h5>Valor em Cartão de Crédito R$ <?=$debit?></h5>
                            <h5>Valor em Cartão de Débito R$ <?=$credit?></h5>

                            <h3>Saída</h3>
                            <h5>Valor Retirado do Caixa R$ <?=$expense?></h5>

                            <h3>Total do Caixa R$ <?=$inCash-$expense?></h3>
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