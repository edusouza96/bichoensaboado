<?php
    if(empty($_GET['idAddress'])){
        $idAddress = '';
    }else{
        $idAddress = $_GET['idAddress'];
    }
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/AddressDAO.php");
    $addressDao = new AddressDAO();
    $address = $addressDao->SearchId($idAddress);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <title>Cadastro de Bairros</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
    </head>
    <body>
        <div class="jumbotron">
            <h2>Bairros</h2>
        </div>
        <form action="../../controller/Manager.php" method="POST">
            <input type="hidden" name="module" value="address"> 
            <input type="hidden" name="idAddress" value="<?=$idAddress?>" > 
            <div class="container">
                <div class="row"> <!--div line district-->
                    <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4"><!--div name district-->
                        <div class="form-group"> 
                            <label for="district">Nome do Bairro</label>
                            <input type="text" id="district" name="district" class="form-control" value="<?=$address->district?>" required>
                        </div>
                    </div><!-- end div name district-->
                </div><!-- end div line name district-->

                <div class="row"> <!--div line valuation-->
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2"> <!--div valuation-->
                        <div class="form-group"> 
                            <label for="valuation">Valor</label>
                            <input type="text" id="owner" name="valuation" class="form-control" value="<?=$address->valuation?>" required>
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
