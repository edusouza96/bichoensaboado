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
        <meta charset="UTF-8">
        <title>Cadastro de Serviços</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
    </head>
    <body>
        <div class="jumbotron">
            <h2>Serviços</h2>
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
                            <label for="nameServic">Nome do Serviço</label>
                            <input type="text" id="nameServic" name="nameServic" class="form-control" value="<?=$servic->nameServic?>" required>
                        </div>
                    </div><!-- end div name Servic-->
                </div><!-- end div line name servic-->

                <div class="row"> <!--div line package-->
                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"> <!--div package-->
                        <div class="form-group"> 
                            <label for="package">Pacote</label>
                            <select id="package" name="package" class="form-control">
                                <option value="0" <?=$servic->package == 0 ? 'selected' : '' ?> >Não</option>
                                <option value="1" <?=$servic->package == 1 ? 'selected' : '' ?> >15 Dias</option>
                                <option value="2" <?=$servic->package == 2 ? 'selected' : '' ?> >30 Dias</option>
                            </select>
                        </div>
                    </div> <!-- end div package-->
                </div><!-- end div line package-->

                <div class="row"> <!--div line breed-->
                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"> <!--div breed-->
                        <div class="form-group"> 
                            <label for="breed">Raça</label>
                            <select id="breed" name="breed" class="form-control">
                                <option value="0">-- Selecione --</option>
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
