<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/TreasurerDAO.php");
    $treasurerDao = new TreasurerDAO();
    $treasurerClass = $treasurerDao->searchLastId();

    $dateRegister =  strtotime($treasurerClass->dateRegistryTreasurer);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <title>Transferencia entre caixas</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
    </head>
    <body>
        <div class="jumbotron">
            <h2>Transferencias</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        
        <form action="../../controller/Manager.php" method="POST">
            <input type="hidden" name="module" value="treasurer-transfer"> 
            <div class="container">

                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2 text-center">
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <h3 class="panel-title">Caixa inicial<br> do dia</h3>
                            </div>
                            <div class="panel-body">
                                <strong>R$ <?=$treasurerClass->startingMoneyDayTreasurer?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2 text-center">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Caixa final<br> do dia</h3>
                            </div>
                            <div class="panel-body">
                                <strong>R$ <?=$treasurerClass->closingMoneyDayTreasurer?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2 text-center">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Total do caixa<br> principal</h3>
                            </div>
                            <div class="panel-body">
                                <strong>R$ <?=$treasurerClass->moneyDrawerTreasurer?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2 text-center">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Total do caixa<br> poupança</h3>
                            </div>
                            <div class="panel-body">
                                <strong>R$ <?=$treasurerClass->moneySavingsTreasurer?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2  text-center">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Total do caixa<br> banco</h3>
                            </div>
                            <div class="panel-body">
                                <strong>R$ <?=$treasurerClass->moneyBankTreasurer?></strong>
                            </div>
                        </div>
                    </div>
                </div>
                <h5>Último registro <?=date("d/m/Y",$dateRegister)?></h5>                
                <hr>

                <div class="row"> <!--div line tranfer from-->
                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="optionTransferFrom">Tranferir de:</label> 
                            <br>
                            <label class="radio-inline"><input type="radio" value='1' name="optionTransferFrom" required>Caixa Principal</label>
                            <label class="radio-inline"><input type="radio" value='2' name="optionTransferFrom" required>Caixa Poupança</label>
                            <label class="radio-inline"><input type="radio" value='3' name="optionTransferFrom" required>Caixa Banco</label>
                        </div>
                    </div> 
                </div><!-- end div line tranfer from-->

                <div class="row"> <!--div line tranfer to-->
                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                        <div class="form-group">
                            <label for="optionTransferTo">Tranferir para:</label> 
                            <br>
                            <label class="radio-inline"><input type="radio" value='1' name="optionTransferTo" required>Caixa Principal</label>
                            <label class="radio-inline"><input type="radio" value='2' name="optionTransferTo" required>Caixa Poupança</label>
                            <label class="radio-inline"><input type="radio" value='3' name="optionTransferTo" required>Caixa Banco</label>
                        </div>
                    </div> 
                </div><!-- end div line  tranfer to-->

                <div class="row"> <!--div line value tranfer-->
                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3">     
                        <div class="form-group">   
                            <label for="valueTranfer">Valor a ser transferido</label> 
                            <input type="text" id="valueTranfer" name="valueTranfer" class="form-control" required>
                        </div>
                    </div> 
                </div><!-- end div line value tranfer-->

                <div class="row"> <!--div line button-->
                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6"> 
                        <div class="form-group">
                            <input type="submit" id="btnSave" value="Salvar" class="btn btn-default">
                        </div>
                    </div> 
                </div><!-- end div line button-->
               
            </div>
        </form>
    </body>
</html>
