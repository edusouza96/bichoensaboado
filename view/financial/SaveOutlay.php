<?php
    
    if(empty($_GET['idFinancial'])){
        $idFinancial = 0;
    }else{
        $idFinancial = $_GET['idFinancial'];
    }
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/FinancialDAO.php");
    include_once($path."/bichoensaboado/dao/CategoryExpenseFinancialDAO.php");
    include_once($path."/bichoensaboado/class/CategoryExpenseFinancialClass.php");
    $financialDao = new FinancialDAO();
    $financial = $financialDao->SearchId($idFinancial);
    $categoryExpenseDao = new CategoryExpenseFinancialDAO();
    $categoryExpenseList = $categoryExpenseDao->searchAll();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <title>Registrar Gastos</title>
        <?php
            include_once($path."/bichoensaboado/view/inc/cssHeader.php");
        ?>
    </head>
    <body>
        <div class="jumbotron">
            <h2>Gastos</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        
        <form action="../../controller/Manager.php" method="POST">
            <input type="hidden" name="module" value="financial"> 
            <input type="hidden" name="idFinancial" id="idFinancial" value="<?=$idFinancial?>" > 
            <div class="container">
                <div class="row"> <!--div line category expense -->
                    <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6"> <!--div category expense-->
                        <div class="form-group"> 
                            <label for="categoryExpenseFinancial">Categoria da despesa:</label> 
                            <select id="categoryExpenseFinancial" name="categoryExpenseFinancial" class="form-control" onChange="selectTitleExpense(this.value);" required>
                                <option value="">-- Selecione --</option>
                                <?php
                                    $idCategoryExpenseFinancial = $financial->centerCost->categoryExpenseFinancial->idCategoryExpenseFinancial;
                                    $idCenterCost = $financial->centerCost->idCenterCost;
                                    foreach($categoryExpenseList as $categoryExpense){
                                        $idOption = $categoryExpense->idCategoryExpenseFinancial;
                                        $descOption = $categoryExpense->descCategoryExpenseFinancial;
                                        $selected = ($idCategoryExpenseFinancial == $idOption ? 'selected':''); 
                                        echo '<option value="'.$idOption.'" '.$selected.'>'.$descOption.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div> <!-- end div category expense-->
                </div><!-- end div line category expense -->

                <div class="row"> <!--div line financial-->
                    <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6"> <!--div financial-->
                        <div class="form-group"> 
                            <label for="centerCost">Titulo</label>
                            <select id="centerCost" name="centerCost" class="form-control" required> 
                                <option value="">-- Selecione uma categoria acima --</option>
                            </select>
                        </div>
                    </div> <!-- end div financial-->
                </div><!-- end div line financial-->

                <div id="rowMulti">
                    <div class="row"> <!--div line -->
                        <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3"> <!--div Valuation-->
                            <div class="form-group"> 
                                <label for="valueProduct">Custo do gasto</label> 
                                <input type="text" id="valueProduct" name="valueProduct[]" class="form-control" value="<?=$financial->valueProduct?>" required>
                            </div>
                        </div> <!-- end div Valuation-->

                        <div class="col-xs-10 col-sm-10 col-lg-3 col-md-3"> <!--div type treasurer-->
                            <div class="form-group"> 
                                <label for="typeTreasurerFinancial">Retirar de:</label> 
                                <select id="typeTreasurerFinancial" name="typeTreasurerFinancial[]" class="form-control" required>
                                        <option value="">-- Selecione --</option>
                                        <option value="1" <?=($financial->typeTreasurerFinancial == 1 ? 'selected':'')?> >Caixa(gaveta)</option>
                                        <option value="2" <?=($financial->typeTreasurerFinancial == 2 ? 'selected':'')?> >Cofre</option>
                                        <option value="4" <?=($financial->typeTreasurerFinancial == 4 ? 'selected':'')?> >Banco</option>
                                </select>
                            </div>
                        </div> <!-- end div type treasurer-->

                        <div class="col-xs-1 col-sm-1 col-lg-1 col-md-1"><!--div button add-->
                            <div class="form-group">
                                <label style="margin-top: 33px;margin-left: -23px;">
                                    <i class="fa fa-plus-circle fa-lg" onclick="addRowFinancial();" aria-hidden="true"></i>
                                </label>
                            </div>
                        </div><!--end div button add-->

                    </div><!-- end div line -->
                </div>

                <div class="row"> <!--div line Dates -->
                    <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3"> <!--div due-->
                        <div class="form-group"> 
                            <label for="dateDueFinancial">Data de Vencimento</label> 
                            <input type="date" id="dateDueFinancial" name="dateDueFinancial" class="form-control" value="<?=$financial->dateDueFinancial?>">
                        </div>
                    </div> <!-- end div due-->

                    <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3"> <!--div pay-->
                        <div class="form-group"> 
                            <label for="datePayFinancial">Data de Pagamento</label> 
                            <input type="date" id="datePayFinancial" name="datePayFinancial" class="form-control" value="<?=$financial->datePayFinancial?>">
                        </div>
                    </div> <!-- end div due-->

                </div><!-- end div line Dates -->

                <div class="row"> <!--div button-->
                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Salvar</button>
                        </div>
                    </div>
                </div><!-- end div button-->

            </div>
            
        </form>
    </body>
</html>
<?php
    include_once($path."/bichoensaboado/view/inc/jsHeader.php");
?>
<script>
    window.onload = function(){
        if($('#idFinancial').val() > 0){
            selectTitleExpense(0<?=$idCategoryExpenseFinancial?>, 0<?=$idCenterCost?>);
        }
    };
</script>