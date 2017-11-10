<?php
    if(empty($_GET['idCenterCost'])){
        $idCenterCost = '';
    }else{
        $idCenterCost = $_GET['idCenterCost'];
    }
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/CenterCostDAO.php");
    include_once($path."/bichoensaboado/dao/CategoryExpenseFinancialDAO.php");
    $centerCostDao = new CenterCostDAO();
    $centerCost = $centerCostDao->searchId($idCenterCost);
    $categoryExpenseFinancialDao = new CategoryExpenseFinancialDAO();
    $categoryExpenseFinancialList = $categoryExpenseFinancialDao->searchAll();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cadastro de Centro de Custo</title>
        <?php
            include_once($path."/bichoensaboado/view/inc/cssHeader.php");
        ?>
    </head>
    <body>
        <div class="jumbotron">
            <h2>Centro de Custo</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        
        <form action="../../controller/Manager.php" method="POST">
            <input type="hidden" name="module" value="center-cost"> 
            <input type="hidden" name="idCenterCost" id="idCenterCost" value="<?=$idCenterCost?>" > 
            <div class="container">
                
                <div class="row"> <!--div row category center cost-->
                    <div class="col-xs-12 col-sm-12 col-lg-7 col-md-7"> <!--div category center cost-->
                        <div class="form-group"> 
                            <label for="categoryExpenseFinancial">Categoria</label>
                            <select id="categoryExpenseFinancial" name="categoryExpenseFinancial" class="form-control">
                                <option value="">-- Selecione --</option>
                                <?php 
                                    foreach($categoryExpenseFinancialList as $categoryExpenseFinancial){ 
                                        if($categoryExpenseFinancial->idCategoryExpenseFinancial == $centerCost->categoryExpenseFinancial->idCategoryExpenseFinancial){
                                ?>
                                    <option value=<?=$categoryExpenseFinancial->idCategoryExpenseFinancial?> selected>
                                        <?=$categoryExpenseFinancial->descCategoryExpenseFinancial?>  
                                    </option>
                                <?php 
                                        }else{
                                ?>
                                    <option value=<?=$categoryExpenseFinancial->idCategoryExpenseFinancial?> >
                                        <?=$categoryExpenseFinancial->descCategoryExpenseFinancial?>  
                                    </option>
                                <?php 
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div> <!-- end div category center cost-->
                </div><!-- end div row category center cost-->

                <div class="row"> <!--div row Name center cost-->
                    <div class="col-xs-12 col-sm-12 col-lg-7 col-md-7"> <!--div Name center cost-->
                        <div class="form-group"> 
                            <label for="nameCenterCost">Nome do Centro de Custo</label>
                            <input type="text" id="nameCenterCost" name="nameCenterCost" class="form-control" value="<?=$centerCost->nameCenterCost?>" required>
                        </div>
                    </div> <!-- end div Name center cost-->
                </div><!-- end div row Name center cost-->

                <div class="row"> <!--div button-->
                    <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-default" value="Salvar">
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