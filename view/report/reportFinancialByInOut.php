<?php
    error_reporting(0);    
    $versionFiles = rand(100, 500);
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/view/inc/util.php");
    include_once($path."/bichoensaboado/dao/ReportDAO.php");
    $reportDao = new ReportDAO();
    
    if(!empty($_POST['dateStart'])){
        $dateStart = $_POST['dateStart'];
        $reportDao->addWhere(" day >= '".$dateStart."'");
    }
    if(!empty($_POST['dateEnd'])){
        $dateEnd = $_POST['dateEnd'];
        $reportDao->addWhere(" day <= '".$dateEnd."'");
    }
    $reportList = $reportDao->reportFinancialByInOut();    
    $namesDistrict = array();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Relatório</title>
        <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=$versionFiles?>">
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Movimentação financeira</h2>
        </div>
        <?php
            include_once($path."/bichoensaboado/view/inc/inc.php");
        ?>
        <form role="form" method="POST">
            
            <div class="container" id="filters">
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
                    
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
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
                    <td colspan="5" class="text-right">
                        <i title="Exportar para Excel" class="fa fa-table fa-2x  cursor" aria-hidden="true" onclick="exportReportToExcel('sheetFinancialByInOut');"></i>
                        <i title="Mostrar/Ocultar Gráfico" class="fa fa-pie-chart fa-2x cursor" aria-hidden="true" onclick="showChart();"></i>
                    </td>
                </tr>
                <tr>
                    <th>Periodo</th>
                    <th>Vendas em Dinheiro</th>
                    <th>Vendas em Cartão</th>
                    <th>Despesas</th>
                    <th>Lucro no Periodo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $chartData = array();
                    $totalCash = 0;
                    $totalCredit = 0;
                    $totalExpenses = 0;
                    $totalGain = 0;                   
                    foreach($reportList as $item){
                        echo "<tr>";
                        echo "<td>";
                        echo $item->column5Report;
                        echo "</td>";

                        echo "<td>";
                        echo $item->column1Report;
                        echo "</td>";

                        echo "<td>";
                        echo $item->column2Report;
                        echo "</td>";

                        echo "<td>";
                        echo $item->column3Report;
                        echo "</td>";

                        echo "<td>";
                        echo $item->column4Report;
                        echo "</td>";
                        echo "</tr>";

                        $totalCash += $item->column1Report;
                        $totalCredit += $item->column2Report;
                        $totalExpenses += $item->column3Report;
                        $totalGain += $item->column4Report;
                        $chartData[] = array(
                            "label" => utf8_encode($item->column5Report), 
                            "backgroundColor" => generationColorRGB(),
                            "borderColor" => "#fff", 
                            "borderWidth" => 1, 
                            "data" => array($item->column4Report)
                        );
                    }
                ?>
                <tr class="row-total">
                    <td>TOTAL</td>
                    <td><?=number_format($totalCash, 2, '.','')?></td>
                    <td><?=number_format($totalCredit, 2, '.','')?></td>
                    <td><?=number_format($totalExpenses, 2, '.','')?></td>
                    <td><?=number_format($totalGain, 2, '.','')?></td>
                </tr>
            </tbody>
        </table>
        <canvas class="hidden" id="reportChart"></canvas>            
       
    </body>
</html>

<script language="javascript" src="../../js/functionsModules.js?v=<?=$versionFiles?>"></script>
<script language="javascript" src="../../js/jquery.js"></script>
<script language="javascript" src="../../js/chart.min.js"></script>
<script type="text/javascript">
    $(function () {
        var obj = <?php echo json_encode($chartData);?>;

        var ctx = document.getElementById('reportChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Lucro por Periodo'],
                datasets:obj
               
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }

        });
    });
</script>
