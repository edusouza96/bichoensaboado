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
        $reportDao->addWhere(" day >= '".$dateStart."'");
    }
    if(!empty($_GET['dateEnd'])){
        $dateEnd = $_GET['dateEnd'];
        $reportDao->addWhere(" day <= '".$dateEnd."'");
    }
    $reportList = $reportDao->reportFinancialByInOut();    
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
                    <th>Periodo</th>
                    <th>Vendas em Dinheiro</th>
                    <th>Vendas em Cartão</th>
                    <th>Despesas</th>
                    <th>Lucro no Periodo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                     $totalCash = 0;
                     $totalCredit = 0;
                     $totalExpenses = 0;
                     $totalGain = 0;      
                    foreach($reportList as $item){
                ?>
                       <tr>
                            <td><?=$item->column5Report?></td>
                           <td><?=$item->column1Report?></td>
                           <td><?=$item->column2Report?></td>
                           <td><?=$item->column3Report?></td>
                           <td><?=$item->column4Report?></td>
                       </tr>
                <?php   
                        $totalCash += $item->column1Report;
                        $totalCredit += $item->column2Report;
                        $totalExpenses += $item->column3Report;
                        $totalGain += $item->column4Report;
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
       
    </body>
</html>