<?php
    $path = $_SERVER['DOCUMENT_ROOT']; 
    $search = isset($_POST['search']) ? $_POST['search'] : null;
    include_once($path."/bichoensaboado/dao/DiaryDAO.php");
    $diaryDao = new DiaryDAO();
    if(empty($search)){
        $diaryList = [];
    }else{
        $diaryList = $diaryDao->searchByNameAnimal($search);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Historico Clientes</title>
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <script language="javascript" src="../../js/ajax.js?v=2"></script>
        <script language="javascript" src="../../js/functionsModules.js?v=2"></script>
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
        <link rel="icon" type="image/png" href="/bichoensaboado/img/logo.jpg" />
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Histórico Clientes</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        
        <form role="form" method="POST">
            <div class="form-group col-xs-4 col-sm-4 col-lg-4 col-md-4">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchBar" name="search" placeholder="Nome do Pet" />
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
                    <th class="text-center">Proprietario</th>
                    <th class="text-center">Nome Animal</th>
                    <th class="text-center">Raça</th>
                    <th class="text-center">Data</th>
                    <th class="text-center">Serviço</th>
                    <th class="text-center">Check-in</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($diaryList as $diary){
                
                        echo "<tr>";
                        echo "<td>";
                        echo $diary->client->owner;
                        echo "</td>";

                        echo "<td>";
                        echo $diary->client->nameAnimal;
                        echo "</td>";

                        echo "<td>";
                        echo $diary->client->breed->nameBreed;
                        echo "</td>";

                        echo "<td>";
                        echo date("d/m/Y H:i", strtotime($diary->dateHour));
                        echo "</td>";

                        echo "<td>";
                        echo $diary->getNameServic();
                        echo "</td>";

                        echo "<td>";
                        echo $diary->checkinHourDiary;
                        echo "</td>";
                        echo "</tr>";
                    }
                    
                ?>
                
            </tbody>
        </table>
    </body>
</html>