<?php
    $path = $_SERVER['DOCUMENT_ROOT'];

    include_once($path."/bichoensaboado/dao/CategoryExpenseFinancialDAO.php");
    $categoryExpenseDao = new CategoryExpenseFinancialDAO();
    $categoryExpenseList = $categoryExpenseDao->searchAll();
?>
<div class="modal fade" id="confirmStartingMoney" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-info-circle" aria-hidden="true"></i> Informação</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="info-value-starting">
                    <div class="col-xs-10 col-sm-10 col-lg-10 col-md-10">
                        <div class="form-group">
                            <h4>Caixa Inicial</h4>
                            <h5 id="valueStartingMoney"></h5>
                        </div>
                    </div>
                </div>
                <!-- Form to refresh data financial -->
                <form style="display: none;" id="form-update" action="../../controller/Manager.php" method="POST">
                    <input type="hidden" name="module" value="financialPDV">
                    <input type="hidden" name="typeTreasurerFinancial" value="1">
                    
                    <div class="container">
                        <div class="row">
                            <!--div line category expense -->
                            <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
                                <!--div category expense-->
                                <div class="form-group">
                                    <label for="categoryExpenseFinancial">Categoria da despesa:</label>
                                    <select id="categoryExpenseFinancial" name="categoryExpenseFinancial" class="form-control" onChange="selectTitleExpense(this.value);" required>
                                        <option value="">-- Selecione --</option>
                                            <?php
                                                $idCenterCost = $financial->centerCost->idCenterCost;
                                                foreach($categoryExpenseList as $categoryExpense){
                                                    $idOption = $categoryExpense->idCategoryExpenseFinancial;
                                                    $descOption = $categoryExpense->descCategoryExpenseFinancial;
                                                    echo '<option value="'.$idOption.'" >'.$descOption.'</option>';
                                                }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <!-- end div category expense-->
                        </div>
                        <!-- end div line category expense -->

                        <div class="row">
                            <!--div line financial-->
                            <div class="col-xs-12 col-sm-12 col-lg-6 col-md-6">
                                <!--div financial-->
                                <div class="form-group">
                                    <label for="centerCost">Titulo</label>
                                    <select id="centerCost" name="centerCost" class="form-control" required>
                                        <option value="">-- Selecione uma categoria acima --</option>
                                    </select>
                                </div>
                            </div>
                            <!-- end div financial-->
                        </div>
                        <!-- end div line financial-->

                        <div class="row">
                            <!--div line Dates -->
                            <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3">
                                <!--div due-->
                                <div class="form-group">
                                    <label for="dateDueFinancial">Data de Vencimento</label>
                                    <input type="date" id="dateDueFinancial" name="dateDueFinancial" class="form-control">
                                </div>
                            </div>
                            <!-- end div due-->

                            <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3">
                                <!--div pay-->
                                <div class="form-group">
                                    <label for="datePayFinancial">Data de Pagamento</label>
                                    <input type="date" id="datePayFinancial" name="datePayFinancial" class="form-control">
                                </div>
                            </div>
                            <!-- end div due-->

                        </div>
                        <!-- end div line Dates -->

                        <div class="row">
                            <!--div line -->
                            <div class="col-xs-12 col-sm-12 col-lg-3 col-md-3">
                                <!--div Valuation-->
                                <div class="form-group">
                                    <label for="valueProduct">Custo do gasto</label>
                                    <input type="text" id="valueProduct" name="valueProduct" class="form-control" required>
                                </div>
                            </div>
                            <!-- end div Valuation-->
                        </div>
                        <!-- end div line -->

                        <div class="row">
                            <!--div button-->
                            <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Salvar</button>
                                </div>
                            </div>
                        </div>
                        <!-- end div button-->

                    </div>

                </form>
                
            </div>
            <div class="modal-footer" id="btn-footer">
                <button type="button" class="btn btn-danger" onclick="showHideElements();">Corrigir</button>
                <button type="button" class="btn btn-success" onclick="openCloseTreasurer(1);" data-dismiss="modal">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<script>

    function showHideElements(){
        $("#form-update").show();
        $("#info-value-starting").hide();
        $("#btn-footer").hide();
    }

    function selectTitleExpense(idCategory, idCenterCost = 0){
        $.get( "../ajax/selectTitleExpense.php", { 
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