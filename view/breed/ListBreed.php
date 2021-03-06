<?php
    
    error_reporting(0);    
    $path = $_SERVER['DOCUMENT_ROOT']; 
    $search = $_POST['search'];
    include_once($path."/bichoensaboado/dao/BreedDAO.php");
    $breedDao = new BreedDAO();
    if(empty($search)){
        $breedList = $breedDao->SearchAll();
    }else{
        $breedList = $breedDao->SearchByName($search);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Lista de Raças</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <script language="javascript" src="../../js/ajax.js?v=2"></script>
        <script language="javascript" src="../../js/functionsModules.js?v=2"></script>
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Raças</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <a href="SaveBreed.php" class='btn btn-success btn-sm'style=" float: right;">
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
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Raça</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($breedList as $breed){
                  
                        echo "<td>";
                        echo $breed->nameBreed;
                        echo "</td>";

                        echo "<td>";
                        echo "<a href='SaveBreed.php?idBreed=".$breed->idBreed."' class='btn btn-info btn-sm'>";
                        echo "<span class='glyphicon glyphicon-pencil'></span>"; 
                        echo "</a>";
                        echo "&emsp;";
                        echo "<a onClick='deleteRegister(".$breed->idBreed.", &quot;Breed&quot;);' class='btn btn-danger btn-sm'>";
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