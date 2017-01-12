<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/ClientDAO.php");
    include_once($path."/bichoensaboado/dao/ServicDAO.php");
    include_once($path."/bichoensaboado/dao/AddressDAO.php");
    $clientDao = new ClientDAO();
    $clientList = $clientDao->SearchAll();
    $servicDao = new ServicDAO();
    $servicList = $servicDao->SearchAll();
    $addressDao = new AddressDAO();
    $addressList = $addressDao->SearchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Lista de Clientes</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <script language="javascript" src="../../js/ajax.js?v=2"></script>
        <script language="javascript" src="../../js/functionsModules.js?v=2"></script>
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Clientes</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <a href="SaveClient.php" class='btn btn-success btn-sm'style="margin-top: -5.5%;float: right;">
            <span class='glyphicon glyphicon-plus'></span> Adicionar
        </a>
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nome Animal</th>
                    <th>Raça</th>
                    <th>Proprietario</th>
                    <th>Bairro</th>
                    <th>Endereço</th>
                    <th>Telefone 1</th>
                    <th>Telefone 2</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($clientList as $client){
                  
                        echo "<td>";
                        echo $client->nameAnimal;
                        echo "</td>";

                        echo "<td>";
                        echo $client->breed->nameBreed;
                        echo "</td>";

                        echo "<td>";
                        echo $client->owner;
                        echo "</td>";

                        echo "<td>";
                        echo $client->address->district;
                        echo "</td>";

                        echo "<td>";
                        echo $client->addressNumber;
                        echo "</br>";
                        echo $client->addressComplement;
                        echo "</td>";

                        echo "<td>";
                        echo $client->phone1;
                        echo "</td>";

                        echo "<td>";
                        echo $client->phone2;
                        echo "</td>";

                        echo "<td>";
                        echo $client->email;
                        echo "</td>";

                        echo "<td>";
                        echo "<a href='SaveClient.php?idClient=".$client->idClient."' class='btn btn-info btn-sm'>";
                        echo "<span class='glyphicon glyphicon-pencil'></span>"; 
                        echo "</a>";
                        echo "&emsp;";
                        echo "<a onClick='deleteRegister(".$client->idClient.", &quot;Client&quot;);' class='btn btn-danger btn-sm'>";
                        echo "<span class='glyphicon glyphicon-trash'></span>";
                        echo "</a>";
                        echo "</td>";
                      
                        echo "</tr>";
                        
                    }
                       
                ?>
                
            </tbody>
        </table>
       
    </body>
</html>