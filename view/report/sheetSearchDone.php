<?php
    $nameReport = "relatorio".date("dmY_Hmi").".xls";
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-Type: application/x-msexcel');
    header ("Content-Disposition: attachment; filename=\"{$nameReport}\"");
    error_reporting(0);    

    $path = $_SERVER['DOCUMENT_ROOT']; 
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
    <body>
        <table border="1" id="tableReport1" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td colspan="4" class="text-left">
                        <h4>Buscas realizadas</h4>
                    </td>
                </tr>
                <tr>
                    <th>Data</th>
                    <th>Bairro</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    ksort($reportSearch);
                    $totalQuantity = 0;
                    $totalValueIn = 0;
                    /*Table show valuations of search done*/
                    foreach($reportSearch as $keyItensByPeriod => $valueItensByPeriod){
                        foreach($valueItensByPeriod as $keyItem => $valueItem){
                ?>
                            <tr>
                                <td><?=$keyItensByPeriod?></td>
                                <td><?=$keyItem?></td>
                                <td><?=$valueItem['quantity']?></td>
                                <td><?=number_format($valueItem['value'], 2, '.','')?></td>
                            </tr>
                        
                <?php   
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
        <br>        
        <br>
        <table border="1" id="tableReport2" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td colspan="3" class="text-left">
                        <h4>Descontos</h4>
                    </td>
                </tr>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalValueOut = 0;
                    /*Table show the discounts*/
                    foreach($reportOutList as $item){
                ?>
                        <tr>
                            <td><?=date("d/m/Y", strtotime($item->column3Report))?></td>
                            <td><?=$item->column1Report?></td>
                            <td><?=$item->column2Report;?></td>
                        </tr>
                <?php   
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
        <br>        
        <br>
        <table border="1" id="tableReport3" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td colspan="3" class="text-left">
                        <h4>Resumo</h4>
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