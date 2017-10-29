<?php
    $nameReport = "relatorio".date("dmY_Hmi").".xls";
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-Type: application/x-msexcel');
    header ("Content-Disposition: attachment; filename=\"{$nameReport}\"");
    error_reporting(0);    

    $path = $_SERVER['DOCUMENT_ROOT']; 
    include_once($path."/bichoensaboado/dao/ReportDAO.php");
    $reportDao = new ReportDAO();
    
    if(!empty($_GET['dateStart'])){
        $dateStart = $_GET['dateStart'];
        $reportDao->addWhere(" dateHour >= '".$dateStart." 00:00:00'");
    }
    if(!empty($_GET['dateEnd'])){
        $dateEnd = $_GET['dateEnd'];
        $reportDao->addWhere(" dateHour <= '".$dateEnd." 23:59:59'");
    }
    $reportList = $reportDao->reportSearchDoneByPeriod();    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <body>
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td colspan="4" class="text-right">
                        <i class="fa fa-table fa-2x" aria-hidden="true"></i>
                        <i class="fa fa-pie-chart fa-2x" aria-hidden="true"></i>
                    </td>
                </tr>
                <tr>
                    <th>Nome</th>
                    <th>Bairro</th>
                    <th>Data</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                     $totalQuantity = 0;
                     $totalValue = 0;
                    foreach($reportList as $item){
                ?>
                       <tr>
                           <td><?=$item->column1Report." (".$item->column2Report.")"?></td>
                           <td><?=$item->column3Report?></td>
                           <td><?=date("d/m/Y", strtotime($item->column4Report))?></td>
                           <td><?=$item->column5Report?></td>
                       </tr>
                <?php   
                        $totalQuantity ++;
                        $totalValue += $item->column5Report;
                    }
                ?>
                <tr class="row-total">
                    <td>TOTAL</td>
                    <td><?=$totalQuantity?></td>
                    <td>-</td>                    
                    <td><?=number_format($totalValue, 2, '.','')?></td>
                </tr>
            </tbody>
        </table>
       
    </body>
</html>