<?php 
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
                            <h5>R$ <span id="starting_money_day_treasurer"></span></h5>

                            <h3>Valores Arrecadados</h3>
                            <h5>Dinheiro R$ <span id="in_cash">0.00</span></h5>
                            <h5>Cartão de Débito R$ <span id="debit">0.00</span></h5>
                            <?php if($admin){ ?>
                                <h6>Com desconto da aliquota R$ <span id="debit_aliquot">0.00</span></h6>
                            <?php } ?>
                            <h5>Cartão de Crédito R$ <span id="credit">0.00</span></h5>
                            <?php if($admin){ ?>
                                <h6>Com desconto da aliquota R$ <span id="credit_aliquot">0.00</span></h6>
                            <?php } ?>

                            <h3>Valores Retirado</h3>
                            <h5>Caixa R$ <span id="expense_drawer">0.00</span></h5>
                            <?php if($admin){ ?>
                            <h5>Cofre R$ <span id="expense_savings">0.00</span></h5>
                            <h5>Banco R$ <span id="expense_bank">0.00</span></h5>
                            <h5>PagSeguro R$ <span id="expense_bank_online">0.00</span></h5>
                            <?php } ?>

                            <h3>Total</h3> 
                            <h5>Caixa R$ <span id="money_drawer_treasurer"></span></h5>
                            <?php if($admin){ ?>
                            <h5>PagSeguro R$ ~<span id="money_bank_online_treasurer"></span></h5>
                            <h5>Cofre R$ <span id="money_savings_treasurer"></span></h5>
                            <h5>Banco R$ <span id="money_bank_treasurer"></span></h5>
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

<script>
    function showDayMovement () {
        $.get("../view/ajax/reportDayMovement.php")
        .done(function(data) {
            data = JSON.parse(data).pop();
            
            if(data.column3Report == 1){
                $('#in_cash').text(data.column1Report);
            }else if(data.column3Report == 2){
                $('#debit').text(data.column1Report);
                $('#debit_aliquot').text(data.column5Report);
            }else if(data.column3Report == 3){
                $('#credit').text(data.column1Report);
                $('#credit_aliquot').text(data.column5Report);
            }else{
                if(data.column4Report == 1){
                    $('#expense_drawer').text(data.column1Report);
                }else if(data.column4Report == 2){
                    $('#expense_savings').text(data.column1Report);
                }else if(data.column4Report == 3){
                    $('#expense_bank_online').text(data.column1Report);
                }else if(data.column4Report == 4){
                    $('#expense_bank').text(data.column1Report);
                }
            }
        });

        $.get("../view/ajax/treasurer.php",{
            "option" : "lastid"
        })
        .done(function(data) {
            data = JSON.parse(data);

            $('#starting_money_day_treasurer').text(data.startingMoneyDayTreasurer);
            $('#money_drawer_treasurer').text(data.moneyDrawerTreasurer);
            $('#money_bank_online_treasurer').text(data.moneyBankOnlineTreasurer);
            $('#money_savings_treasurer').text(data.moneySavingsTreasurer);
            $('#money_bank_treasurer').text(data.moneyBankTreasurer);
        });

        $('#dayMovement').modal('show');
    }
</script>