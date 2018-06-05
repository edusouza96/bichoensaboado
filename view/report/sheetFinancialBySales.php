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
        $reportDao->addWhere(" datePayFinancial >= '".$dateStart."'");
    }
    if(!empty($_GET['dateEnd'])){
        $dateEnd = $_GET['dateEnd'];
        $reportDao->addWhere(" datePayFinancial <= '".$dateEnd."'");
    }
    $reportList = $reportDao->reportFinancialBySales();    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <body>
        <table border="1" id="tableDiary" class="table table-condensed table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td colspan="3" class="text-right">
                        <i class="fa fa-table fa-2x" aria-hidden="true"></i>
                        <i class="fa fa-pie-chart fa-2x" aria-hidden="true"></i>
                    </td>
                </tr>
                <tr>
                    <th>Descrição</th>
                    <th>Unidades</th>
                    <th>Valor</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalUnit = 0;
                    $totalValue = 0;
                    foreach($reportList as $item){
                ?>
                       <tr>
                           <td><?=$item->column4Report?></td>
                           <td><?=$item->column5Report?></td>
                           <td><?=$item->column2Report?></td>
                           <td><?=date("d/m/Y", strtotime($item->column3Report))?></td>
                       </tr>
                <?php   
                        $totalUnit += $item->column5Report;
                        $totalValue += $item->column2Report;
                    }
                ?>
                 <tr class="row-total">
                    <td>TOTAL</td>
                    <td><?=number_format($totalUnit, 2, '.','')?></td>
                    <td><?=number_format($totalValue, 2, '.','')?></td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
       
    </body>
</html>