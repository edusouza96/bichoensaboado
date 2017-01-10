<?php
    if(empty($_GET['idClient'])){
        $idClient = '';
    }else{
        $idClient = $_GET['idClient'];
    }
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/BreedDAO.php");
    include_once($path."/bichoensaboado/dao/AddressDAO.php");
    include_once($path."/bichoensaboado/dao/ClientDAO.php");
    $breedDao = new BreedDAO();
    $breedList = $breedDao->SearchAll();
    $addressDao = new AddressDAO();
    $addressList = $addressDao->SearchAll();
    $clientDao = new ClientDAO();
    $client = $clientDao->SearchId($idClient);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO 8895-1">
        <title>Cadastro de Clientes</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
    </head>
    <body>
        <div class="jumbotron">
            <h2>Clientes</h2>
        </div>
        <form action="../../controller/Manager.php" method="POST">
            <input type="hidden" name="module" value="client"> 
            <input type="hidden" name="idClient" value="<?=$idClient?>" > 
            <div class="container">
                <div class="row"> <!--div line animal-->
                    <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4"><!--div name animal-->
                        <div class="form-group"> 
                            <label for="nameAnimal">Nome do Animal</label>
                            <input type="text" id="nameAnimal" name="nameAnimal" class="form-control" value="<?=$client->nameAnimal?>" required>
                        </div>
                    </div><!-- end div name animal-->

                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2"> <!--div breed-->
                        <div class="form-group"> 
                            <label for="breed">Raça</label>
                            <select id="breed" name="breed" class="form-control" required>
                                <option value="">-- Selecione --</option>
                                <?php 
                                    foreach($breedList as $breed){ 
                                        if($client->breed->idBreed == $breed->idBreed){
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

                <div class="row"> <!--div line owner-->
                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6"> <!--div owner-->
                        <div class="form-group"> 
                            <label for="owner">Proprietário</label>
                            <input type="text" id="owner" name="owner" class="form-control" value="<?=$client->owner?>" required>
                        </div>
                    </div> <!-- end div owner-->
                </div><!-- end div line owner-->

                <div class="row"> <!--div line address-->
                    <div class="col-xs-2 col-sm-2 col-lg-2 col-md-2"><!--div district-->
                        <div class="form-group"> 
                            <label for="address">Bairro</label>
                            <select id="address" name="address" class="form-control" required>
                                <option value="">-- Selecione --</option>
                                <?php 
                                    foreach($addressList as $address){ 
                                        if($client->address->idAddress == $address->idAddress){
                                ?>
                                 <option value=<?=$address->idAddress?> selected>
                                    <?=$address->district?>  
                                 </option>
                                <?php 
                                        }else{
                                ?>
                                <option value=<?=$address->idAddress?>>
                                    <?=$address->district?>  
                                 </option>
                                <?php 
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div><!-- end div district-->

                    <div class="col-xs-4 col-sm-4 col-lg-4 col-md-4"> <!--div street and number-->
                        <div class="form-group"> 
                            <label for="addressNumber">Endereço</label>
                            <input type="text" id="addressNumber" name="addressNumber" class="form-control" value="<?=$client->addressNumber?>">
                        </div>
                    </div><!-- end div streer and number-->
                </div> <!-- end div line address-->

                <div class="row"> <!--div line address complement-->
                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6"> <!--div street and address complement-->
                        <div class="form-group"> 
                            <label for="addressComplement">Complemento</label>
                            <input type="text" id="addressComplement" name="addressComplement" class="form-control" value="<?=$client->addressComplement?>">
                        </div>
                    </div><!-- end div address complement-->
                </div> <!-- end div line address complement-->

                <div class="row"> <!--div line phone-->
                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"><!--div phone1-->
                        <div class="form-group"> 
                            <label for="phone1">Telefone 1</label>
                            <input type="text" id="phone1" name="phone1" class="form-control" value="<?=$client->phone1?>" required>
                        </div>
                    </div><!-- end div phone1-->

                    <div class="col-xs-3 col-sm-3 col-lg-3 col-md-3"><!--div phone2-->
                        <div class="form-group"> 
                            <label for="phone2">Telefone 2</label>
                            <input type="text" id="phone2" name="phone2" class="form-control" value="<?=$client->phone2?>">
                        </div>
                    </div><!-- end div phone2-->
                </div><!-- end div line phone-->

                <div class="row"><!-- div line email-->
                    <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6"><!--div email-->
                        <div class="form-group"> 
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" class="form-control"  value="<?=$client->email?>">
                        </div>
                    </div><!-- end div email-->
                </div><!-- end div line email-->

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
