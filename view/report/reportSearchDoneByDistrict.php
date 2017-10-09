<?php
    error_reporting(0);    
    $path = $_SERVER['DOCUMENT_ROOT']; 
    $search = $_POST['search'];
    include_once($path."/bichoensaboado/dao/ReportDAO.php");
    $reportDao = new ReportDAO();
    
    if(!empty($_POST['dateStart'])){
        $dateStart = $_POST['dateStart'];
        $reportDao->addWhere(" dateHour >= '".$dateStart." 00:00:00'");
    }
    if(!empty($_POST['dateEnd'])){
        $dateEnd = $_POST['dateEnd'];
        $reportDao->addWhere(" dateHour <= '".$dateEnd." 23:59:59'");
    }
    $reportList = $reportDao->reportSearchDoneByDistrict();    
    $namesDistrict = array();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Relatório</title>
        <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
        <script language="javascript" src="../../js/functionsModules.js?v=2"></script>
        <script language="javascript" src="../../js/jquery.js"></script>
        <script language="javascript" src="../../js/chart.min.js"></script>

    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Busca realizadas por bairro</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <form role="form" method="POST">
            <h4 class="cursor" id="showFilters" onclick="reportShowFilters();">Exibir Filtro</h4>
            <div class="container hidden" id="filters">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                        <div class="form-group">
                            <label>Periodo:</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                        <div class="form-group">
                            <label for="dateStart">De</label>
                            <input type="date" id="dateStart" name="dateStart" class="form-control" value="<?=$dateStart?>">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                        <div class="form-group">
                            <label for="dateEnd">Até</label>
                            <input type="date" id="dateEnd" name="dateEnd" class="form-control" value="<?=$dateEnd?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <input type="submit" id="btn-search" class="btn btn-info" value="buscar">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td colspan="3" class="text-right">
                        <i class="fa fa-table fa-2x" aria-hidden="true" onclick="window.open('sheetSearchDoneByDistrict.php');"></i>
                        <i class="fa fa-pie-chart fa-2x cursor" aria-hidden="true"></i>
                    </td>
                </tr>
                <tr>
                    <th>Quantidade</th>
                    <th>Bairro</th>
                    <th>Valor gerado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($reportList as $item){
                        echo "</tr>";
                        echo "<td>";
                        echo $item->column1Report;
                        echo "</td>";

                        echo "<td>";
                        echo $item->column2Report;
                        echo "</td>";

                        echo "<td>";
                        echo $item->column3Report;
                        echo "</td>";
                        echo "</tr>";
                    }
                       
                    
                    $teste = array(
                        array("label" => "centro", "backgroundColor" => generationColorRGB(),"borderColor" => "#fff", "borderWidth" => 1, "data" => array(4)),
                        array("label" => "condado", "backgroundColor" => generationColorRGB(),"borderColor" => "#fff", "borderWidth" => 1, "data" => array(1)),
                        array("label" => "jardim fiuza", "backgroundColor" => generationColorRGB(),"borderColor" => "#fff", "borderWidth" => 1, "data" => array(1)),
                        array("label" => "nao definido", "backgroundColor" => generationColorRGB(),"borderColor" => "#fff", "borderWidth" => 1, "data" => array(5)),
                        array("label" => "PASSO DO VIGARIO	", "backgroundColor" => generationColorRGB(),"borderColor" => "#fff", "borderWidth" => 1, "data" => array(6)),
                        array("label" => "SAINT HILARE	", "backgroundColor" => generationColorRGB(),"borderColor" => "#fff", "borderWidth" => 1, "data" => array(3)),
                        array("label" => "SaO LUCAS	", "backgroundColor" => generationColorRGB(),"borderColor" => "#fff", "borderWidth" => 1, "data" => array(8)),
                        array("label" => "SITIO SaO JOSE	", "backgroundColor" => generationColorRGB(),"borderColor" => "#fff", "borderWidth" => 1, "data" => array(12)),
                        array("label" => "taruma", "backgroundColor" => generationColorRGB(),"borderColor" => "#fff", "borderWidth" => 1, "data" => array(18))
                        );
                ?>
                <canvas id="reportChart"></canvas>            
            </tbody>
        </table>
       
    </body>
</html>



 
<script type="text/javascript">
    $(function () {
        var obj = <?php echo json_encode($teste);?>;

        var ctx = document.getElementById('reportChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Bairros'],
                datasets:obj
               
            }

        });
    });
</script>

<?php
function generationColorRGB(){
    $color1 = mt_rand (1, 255);
    $color2 = mt_rand (1, 255);
    $color3 = mt_rand (1, 255);
    return "RGB(".$color1.",".$color2.",".$color3.")";
}
?>