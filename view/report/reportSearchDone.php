<?php
    error_reporting(0);    
    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/view/inc/util.php");
    include_once($path."/bichoensaboado/dao/ReportDAO.php");
    $reportInDao = new ReportDAO();
    $reportOutDao = new ReportDAO();
    
    if(!empty($_POST['dateStart'])){
        $dateStart = $_POST['dateStart'];
        $reportInDao->addWhere(" dateHour >= '".$dateStart." 00:00:00'");
        $reportOutDao->addWhere(" datePayFinancial >= '".$dateStart."'");
    }
    if(!empty($_POST['dateEnd'])){
        $dateEnd = $_POST['dateEnd'];
        $reportInDao->addWhere(" dateHour <= '".$dateEnd." 23:59:59'");
        $reportOutDao->addWhere(" datePayFinancial <= '".$dateEnd."'");
    }
    $reportInList = $reportInDao->reportSearchDoneByPeriod();    
    $reportOutList = $reportOutDao->reportExpenseWithSearch();    

    $reportSearch = array();
    foreach($reportInList as $item){
        $reportSearch[date("d/m/Y", strtotime($item->column4Report))][$item->column3Report]['value'] += $item->column5Report;
        $reportSearch[date("d/m/Y", strtotime($item->column4Report))][$item->column3Report]['quantity'] += 1;
        $reportSearch[date("d/m/Y", strtotime($item->column4Report))][$item->column3Report]['detail']['name'][] = $item->column1Report;
        $reportSearch[date("d/m/Y", strtotime($item->column4Report))][$item->column3Report]['detail']['value'][] = $item->column5Report;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="ISO 8895-1">
        <title>Relatório</title>
        <link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../css/bootstrap-3.3.7-dist/css/bootstrap.css">
        <link rel="stylesheet" href="../../css/stylePages.css?v=<?=rand(100, 500)?>">
    </head>
    <body>
        <div class="jumbotron"> 
            <h2>Busca realizadas</h2>
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
        <table border="1" id="tableReport1" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td colspan="2" class="text-left" onclick="moreDetails('#tableReportSearch');">
                        <h4>Buscas realizadas</h4>
                    </td>
                    <td colspan="2" class="text-right">
                        <i title="Exportar para Excel" class="fa fa-table fa-2x  cursor" aria-hidden="true" onclick="exportReportToExcel('sheetSearchDone');"></i>
                    </td>
                </tr>
                <tr>
                    <th>Data</th>
                    <th>Bairro</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody id="tableReportSearch" class="hidden">
                <?php
                    ksort($reportSearch);
                    $totalQuantity = 0;
                    $totalValueIn = 0;
                    /*Table show valuations of search done*/
                    foreach($reportSearch as $keyItensByPeriod => $valueItensByPeriod){
                        foreach($valueItensByPeriod as $keyItem => $valueItem){
                            echo "<tr>";
                            
                            echo "<td>";
                            echo $keyItensByPeriod;
                            echo "</td>";

                            echo "<td>";
                            echo $keyItem;
                            echo "</td>";

                            echo "<td>";
                            echo $valueItem['quantity'];
                            echo "</td>";
    
                            echo "<td>";
                            echo number_format($valueItem['value'], 2, '.','');
                            echo "</td>";
                            echo "</tr>"; 
                            $idDiv = str_replace(" ","",$keyItensByPeriod.$keyItem);
                            $idDiv = str_replace("/","",$idDiv);
                          
                            echo "
                                <tr onclick='moreDetails(&quot;#".$idDiv."&quot;);' >
                                    <td colspan='3' class='detais-report' data-toggle='tooltip' title='clique para mais detalhes'>
                                        <div id='".$idDiv."'class='hidden col-md-4'>
                                        <div class='font-weight-bold'> 
                                            <span class='col-md-6'>Nome do Pet</span>
                                            <span class='col-md-6'>Valor da Busca</span>
                                        </div>
                            ";
                                    for($i=0; $i<count($valueItem['detail']['name']); $i++){
                                        echo "
                                            <div> 
                                                <span class='col-md-6'>".$valueItem['detail']['name'][$i]."</span>
                                                <span class='col-md-6'>".$valueItem['detail']['value'][$i]."</span>
                                            </div>
                                        "; 
                                    }
                                            
                            echo        "</div>
                                    </td>
                                </tr>
                            ";
                            
                            $totalQuantity ++;
                            $totalValueIn += $valueItem['value'];
                        }
                    }
                ?>
                <tr class="row-total">
                    <td>TOTAL</td>
                    <td>-</td>                    
                    <td><?=$totalQuantity?></td>
                    <td><?=number_format($totalValueIn, 2, '.','')?></td>
                </tr>
            </tbody>
        </table>

        <table border="1" id="tableReport2" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td colspan="2" class="text-left"  onclick="moreDetails('#tableReportDiscount');">
                        <h4>Descontos</h4>
                    </td>
                    <td colspan="1" class="text-right">
                    </td>
                </tr>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody  id="tableReportDiscount" class="hidden">
                <?php
                    $totalValueOut = 0;
                    /*Table show the discounts*/
                    foreach($reportOutList as $item){
                            echo "<tr>";
                            
                            echo "<td>";
                            echo date("d/m/Y", strtotime($item->column3Report));
                            echo "</td>";

                            echo "<td>";
                            echo $item->column1Report;
                            echo "</td>";

                            echo "<td>";
                            echo $item->column2Report;
                            echo "</td>";
                          
                            echo "</tr>"; 
                           
                            $totalValueOut += $item->column2Report;
                    }
                ?>
                <tr class="row-total">
                    <td>TOTAL</td>
                    <td>-</td>                    
                    <td><?=number_format($totalValueOut, 2, '.','')?></td>
                </tr>
            </tbody>
        </table>

        <table border="1" id="tableReport3" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td colspan="2" class="text-left">
                        <h4>Resumo</h4>
                    </td>
                    <td colspan="1" class="text-right">
                    </td>
                </tr>
                <tr>
                    <th>Total das buscas</th>
                    <th>Total de descontos</th>
                    <th>Valor a pagar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?=number_format($totalValueIn, 2, '.','')?></td>
                    <td><?=number_format($totalValueOut, 2, '.','')?></td>                    
                    <td><?=number_format(($totalValueIn-$totalValueOut), 2, '.','')?></td>
                </tr>
            </tbody>
        </table>


    </body>
</html>
      
<script language="javascript" src="../../js/functionsModules.js?v=2"></script>
<script language="javascript" src="../../js/jquery.min.js"></script>
<script language="javascript" src="../../js/bootstrap.min.js"></script>
<script language="javascript" src="../../js/chart.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>