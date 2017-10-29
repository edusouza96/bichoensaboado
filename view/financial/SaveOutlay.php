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
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
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
            <input type="hidden" name="idFinancial" value="<?=$idFinancial?>" > 
            <div class="container">
                <div class="row"> <!--div line category expense -->
                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6"> <!--div category expense-->
                        <div class="form-group"> 
                            <label for="categoryExpenseFinancial">Categoria da despesa:</label> 
                            <select id="categoryExpenseFinancial" name="categoryExpenseFinancial" class="form-control" required>
                                <option value="">-- Selecione --</option>
                                <?php
                                    $idCategoryExpenseFinancial = $financial->categoryExpenseFinancial;
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
                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6"> <!--div financial-->
                        <div class="form-group"> 
                            <label for="description">Titulo</label>
                            <input type="text" id="description" name="description" class="form-control" value="<?=$financial->description?>" required>
                        </div>
                    </div> <!-- end div financial-->
                </div><!-- end div line financial-->

                <div class="row"> <!--div line Valuation -->
                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6"> <!--div Valuation-->
                        <div class="form-group"> 
                            <label for="valueProduct">Custo do gasto</label> 
                            <input type="text" id="valueProduct" name="valueProduct" class="form-control" value="<?=$financial->valueProduct?>" required>
                        </div>
                    </div> <!-- end div Valuation-->

                </div><!-- end div line Valuation -->

                <div class="row"> <!--div line Dates -->
                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"> <!--div due-->
                        <div class="form-group"> 
                            <label for="dateDueFinancial">Data de Vencimento</label> 
                            <input type="date" id="dateDueFinancial" name="dateDueFinancial" class="form-control" value="<?=$financial->dateDueFinancial?>">
                        </div>
                    </div> <!-- end div due-->

                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"> <!--div pay-->
                        <div class="form-group"> 
                            <label for="datePayFinancial">Data de Pagamento</label> 
                            <input type="date" id="datePayFinancial" name="datePayFinancial" class="form-control" value="<?=$financial->datePayFinancial?>">
                        </div>
                    </div> <!-- end div due-->

                </div><!-- end div line Dates -->

                <div class="row"> <!--div button-->
                    <div class="col-xs-8 col-sm-8 col-lg-8 col-md-82">
                        <div class="form-group">
                            <button type="submit" class="btn btn-default">Salvar</button>
                        </div>
                    </div>
                </div><!-- end div button-->

            </div>
            
        </form>
    </body>
</html>
