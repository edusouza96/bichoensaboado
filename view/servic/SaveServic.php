<?php
    if(empty($_GET['idServic'])){
        $idServic = '';
    }else{
        $idServic = $_GET['idServic'];
    }
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/ServicDAO.php");
    include_once($path."/bichoensaboado/dao/BreedDAO.php");
    $breedDao = new BreedDAO();
    $breedList = $breedDao->SearchAll();
    $servicDao = new ServicDAO();
    $servic = $servicDao->SearchId($idServic);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <title>Cadastro de Servi�os</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
    </head>
    <body>
        <div class="jumbotron">
            <h2>Servi�os</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <form action="../../controller/Manager.php" method="POST">
            <input type="hidden" name="module" value="servic"> 
            <input type="hidden" name="idServic" value="<?=$idServic?>" > 
            <div class="container">
                <div class="row"> <!--div line name servic-->
                    <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4"><!--div name servic-->
                        <div class="form-group"> 
                            <label for="nameServic">Nome do Servi�o</label>
                            <input type="text" id="nameServic" name="nameServic" class="form-control" value="<?=$servic->nameServic?>" required>
                        </div>
                    </div><!-- end div name Servic-->
                </div><!-- end div line name servic-->

                <div class="row"> <!--div line breed-->
                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"> <!--div breed-->
                        <div class="form-group"> 
                            <label for="breed">Ra�a</label>
                            <select id="breed" name="breed" class="form-control">
                                <option value="">-- Selecione --</option>
                                <?php 
                                    foreach($breedList as $breed){ 
                                        if($servic->breed->idBreed == $breed->idBreed){
                                ?>
                                 <option value=<?=$breed->idBreed?> selected>
                                    <?=$breed->nameBreed?>  
                                 </option>
                                <?php 
                                        }else{
                                ?>
                                <option value=<?=$breed->idBreed?> >
                                    <?=$breed->nameBreed?>  
                                 </option>
                                <?php 
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div> <!-- end div breed-->
                </div><!-- end div line animal-->

                <div class="row"> <!--div line valuation-->
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2"> <!--div valuation-->
                        <div class="form-group"> 
                            <label for="valuation">Valor</label>
                            <input type="text" id="owner" name="valuation" class="form-control" value="<?=$servic->valuation?>" required>
                        </div>
                    </div> <!-- end div valuation-->
                </div><!-- end div line valuation-->

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
