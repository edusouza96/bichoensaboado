<?php
    if(empty($_GET['idRebate'])){
        $idRebate = '';
    }else{
        $idRebate = $_GET['idRebate'];
    }
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/RebateDAO.php");
    $rebateDao = new RebateDAO();
    $rebate = $rebateDao->searchId($idRebate);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cadastro de Descontos</title>
        <?php
            include_once($path."/bichoensaboado/view/inc/cssHeader.php");
        ?>
    </head>
    <body>
        <div class="jumbotron">
            <h2>Descontos</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        
        <form action="../../controller/Manager.php" method="POST">
            <input type="hidden" name="module" value="rebate"> 
            <input type="hidden" name="idRebate" id="idRebate" value="<?=$idRebate?>" > 
            <div class="container">
                
                
                <div class="row"> 
                    <div class="col-xs-12 col-sm-12 col-lg-5 col-md-5">
                        <div class="form-group"> 
                            <label for="descriptionRebate">Descrição</label>
                            <input type="text" id="descriptionRebate" name="descriptionRebate" class="form-control" value="<?=$rebate->descriptionRebate?>" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-lg-2 col-md-2">
                        <div class="form-group"> 
                            <label for="valueRebate">Valor</label>
                            <input type="text" id="valueRebate" name="valueRebate" class="form-control" value="<?=$rebate->valueRebate?>" required>
                        </div>
                    </div>
                </div>

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