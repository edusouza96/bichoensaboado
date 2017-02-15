<?php
    error_reporting(0);
    $path = $_SERVER['DOCUMENT_ROOT']; 
    $search = $_POST['search'];
    include_once($path."/bichoensaboado/dao/AddressDAO.php");
    $addressDao = new AddressDAO();
    if(empty($search)){
        $addressList = $addressDao->SearchAll();
    }else{
        $addressList = $addressDao->SearchByName($search);
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Lista de Bairros</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <script language="javascript" src="../../js/ajax.js?v=2"></script>
        <script language="javascript" src="../../js/functionsModules.js?v=2"></script>
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Bairros</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <a href="SaveAddress.php" class='btn btn-success btn-sm'style="margin-top: -5.5%;float: right;">
            <span class='glyphicon glyphicon-plus'></span> Adicionar
        </a>
        <form role="form" method="POST">
            <div class="form-group col-xs-4 col-sm-4 col-lg-4 col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchBar" name="search" placeholder="Buscar" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-info" value="Buscar">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>
        </form>
        <table border="0" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
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
