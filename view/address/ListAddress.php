<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/AddressDAO.php");
    $addressDao = new AddressDAO();
    $addressList = $addressDao->SearchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Lista de Bairros</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <script language="javascript" src="../../js/ajax.js?v=2"></script>
        <script language="javascript" src="../../js/functionsModules.js?v=2"></script>
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Bairros</h2>
        </div>
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Bairro</th>
                    <th>Valor Frete</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($addressList as $address){
                  
                        echo "<td>";
                        echo $address->district;
                        echo "</td>";

                        echo "<td>";
                        echo $address->valuation;
                        echo "</td>";

                        echo "<td>";
                        echo "<a href='SaveAddress.php?idAddress=".$address->idAddress."' class='btn btn-info btn-sm'>";
                        echo "<span class='glyphicon glyphicon-pencil'></span>"; 
                        echo "</a>";
                        echo "&emsp;";
                        echo "<a onClick='deleteRegister(".$address->idAddress.", &quot;Address&quot;);' class='btn btn-danger btn-sm'>";
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
