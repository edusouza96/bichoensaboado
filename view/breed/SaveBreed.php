<?php
    
    if(empty($_GET['idBreed'])){
        $idBreed = '';
    }else{
        $idBreed = $_GET['idBreed'];
    }
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/BreedDAO.php");
    $breedDao = new BreedDAO();
    $breed = $breedDao->SearchId($idBreed);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <title>Cadastro de Raças</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
    </head>
    <body>
        <div class="jumbotron">
            <h2>Raça</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        
        <form action="../../controller/Manager.php" method="POST">
            <input type="hidden" name="module" value="breed"> 
            <input type="hidden" name="idBreed" value="<?=$idBreed?>" > 
            <div class="container">
                <div class="row"> <!--div line breed-->
                    <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4"> <!--div breed-->
                        <div class="form-group"> 
                            <label for="nameBreed">Nome da Raça</label>
                            <input type="text" id="nameBreed" name="nameBreed" class="form-control" value="<?=$breed->nameBreed?>" required>
                        </div>
                    </div> <!-- end div breed-->
                </div><!-- end div line animal-->

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
