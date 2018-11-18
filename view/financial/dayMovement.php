<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once($path."/bichoensaboado/dao/ReportDAO.php");
    $reportDao = new ReportDAO();
    $reportDayMovementList = $reportDao->reportDayMovement();
    $inCash = 0;
    $credit = 0;
    $creditAliquot = 0;
    $debit = 0;
    $debitAliquot = 0;
    $expenseBankOnline = 0;
    $expenseSavings = 0;
    $expenseDrawer = 0;
    $expenseBank = 0;
    foreach($reportDayMovementList as $report){
        if($report->column3Report == 1){
            $inCash = $report->column1Report;
        }else if($report->column3Report == 2){
            $debit = $report->column1Report;
            $debitAliquot = $report->column5Report;
        }else if($report->column3Report == 3){
            $credit = $report->column1Report;
            $creditAliquot = $report->column5Report;
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
<div class="modal fade" id="dayMovement" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
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
                            <h5>Cartão de Débito R$ <?=$debit?></h5>
                            <?php if($admin){ ?>
                                <h6>Com desconto da aliquota R$ <?=$debitAliquot?></h6>
                            <?php } ?>
                            <h5>Cartão de Crédito R$ <?=$credit?></h5>
                            <?php if($admin){ ?>
                                <h6>Com desconto da aliquota R$ <?=$creditAliquot?></h6>
                            <?php } ?>

                            <?php if($admin){ ?>
                            <h3>Valores Retirado</h3>
                            <h5>Caixa R$ <?=$expenseDrawer?></h5>
                            <h5>Cofre R$ <?=$expenseSavings?></h5>
                            <h5>Banco R$ <?=$expenseBank?></h5>
                            <h5>PagSeguro R$ <?=$expenseBankOnline?></h5>
                            <?php } ?>

                            <h3>Total</h3> 
                            <h5>Caixa R$ <?=$treasurerClass->moneyDrawerTreasurer?></h5>
                            <?php if($admin){ ?>
                            <h5>PagSeguro R$ ~<?=$treasurerClass->moneyBankOnlineTreasurer?></h5>
                            <h5>Cofre R$ <?=$treasurerClass->moneySavingsTreasurer?></h5>
                            <h5>Banco R$ <?=$treasurerClass->moneyBankTreasurer?></h5>
                            <?php } ?>
                            <br>
                            
                            <?php if($admin){ ?>
                            <fieldset>
                                <legend>Transferir</legend>
                                <form action="../../controller/Manager.php" method="POST">
                                    <input type="hidden" name="module" value="treasurer-transfer"> 
                                    <input type="hidden" name="page" value="pdv"> 
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5 col-lg-5 col-md-5">
                                            <div class="form-group">
                                                <select name="optionTransferFrom" id="optionTransferFrom" class="form-control" required>
                                                    <option value="">-- Transferir de --</option>
                                                    <option value="1" selected>Caixa</option>
                                                    <option value="2">Cofre</option>
                                                    <option value="3">PagSeguro</option>
                                                    <option value="4">Banco</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-1 col-lg-1 col-md-1">
                                            <div class="form-group">
                                                <i class="fa fa-exchange" aria-hidden="true"></i>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-5 col-lg-5 col-md-5">
                                            <div class="form-group">
                                                <select name="optionTransferTo" id="optionTransferTo" class="form-control col-sm-2 col-md-2 col-xs-2 col-lg-2" required>
                                                    <option value="">-- Transferir para --</option>
                                                    <option value="1">Caixa</option>
                                                    <option value="2">Cofre</option>
                                                    <option value="3">PagSeguro</option>
                                                    <option value="4">Banco</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-5 col-lg-5 col-md-5">
                                            <div class="form-group">
                                                <input type="text" name="valueTranfer" placeholder="valor" id="valueTranfer" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-5 col-lg-5 col-md-5 col-lg-push-1 col-md-push-1 col-sm-push-1">
                                            <div class="form-group">
                                                <input type="password" name="passwordAdmin" placeholder="senha" id="passwordAdmin" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-11 col-lg-11 col-md-11">
                                            <div class="form-group pull-right">
                                                <input type="submit" id="btnSaveTranfer" value="Transferir" class="btn btn-primary" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </fieldset>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script language="javascript" src="/bichoensaboado/js/jquery.min.js"></script>
<script>
     
    $('#passwordAdmin').on('keyup', function(){
        if(this.value == '4518'){
            $('#btnSaveTranfer').attr('disabled', false);
        }else{
            $('#btnSaveTranfer').attr('disabled', true);
        }
    });
</script>