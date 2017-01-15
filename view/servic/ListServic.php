<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/ServicDAO.php");
    $servicDao = new ServicDAO();
    $servicList = $servicDao->SearchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Lista de Servi�os</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <script language="javascript" src="../../js/ajax.js?v=2"></script>
        <script language="javascript" src="../../js/functionsModules.js?v=2"></script>
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Servi�os</h2>
        </div>
            <?php
                include_once($path."/bichoensaboado/view/inc/inc.php");
            ?>
            <a href="SaveServic.php" class='btn btn-success btn-sm'style="margin-top: -5.5%;float: right;">
                <span class='glyphicon glyphicon-plus'></span> Adicionar
            </a>

        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Servi�o</th>
                    <th>Ra�a</th>
                    <th>Valor</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($servicList as $servic){
                  
                        echo "<td>";
                        echo $servic->nameServic;
                        echo "</td>";

                        echo "<td>";
                        echo $servic->breed->nameBreed;
                        echo "</td>";

                        echo "<td>";
                        echo $servic->valuation;
                        echo "</td>";

                        echo "<td>";
                        echo "<a href='SaveServic.php?idServic=".$servic->idServic."' class='btn btn-info btn-sm'>";
                        echo "<span class='glyphicon glyphicon-pencil'></span>"; 
                        echo "</a>";
                        echo "&emsp;";
                        echo "<a onClick='deleteRegister(".$servic->idServic.", &quot;Servic&quot;);' class='btn btn-danger btn-sm'>";
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